<?php namespace Adnduweb\Ci4Medias\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Tatter\Exports\Exceptions\ExportsException;
use  Adnduweb\Ci4Medias\Config\Files as FilesConfig;
use  Adnduweb\Ci4Medias\Exceptions\FilesException;
use  Adnduweb\Ci4Medias\Entities\File;
use  Adnduweb\Ci4Medias\Models\FileModel;

class Files extends Controller
{
	/**
	 * Files config.
	 *
	 * @var FilesConfig
	 */
	protected $config;

	/**
	 * The model to use, may be a child of this library's.
	 *
	 * @var FileModel
	 */
	protected $model;

	/**
	 * Helpers to load.
	 */
	protected $helpers = ['alerts', 'files', 'handlers', 'html', 'text'];

	/**
	 * Overriding data for views.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Preloads the configuration and verifies the storage directory.
	 * Parameters are mostly for testing purposes.
	 *
	 * @param FilesConfig|null $config
	 * @param FileModel|null $model
	 *
	 * @throws FilesException
	 */
	public function __construct(FilesConfig $config = null, FileModel $model = null)
	{
		$this->config = $config ?? config('Files');

		// Use the short model name so a child may be loaded first
		$this->model = $model ?? model('FileModel');

		// Verify the storage directory
		FileModel::storage();
	}

	/**
	 * Verify authentication is configured correctly *after* parent calls loadHelpers().
	 *
	 * @param RequestInterface         $request
	 * @param ResponseInterface        $response
	 * @param \Psr\Log\LoggerInterface $logger
	 *
	 * @throws \CodeIgniter\HTTP\Exceptions\HTTPException
	 * @see https://codeigniter4.github.io/CodeIgniter4/extending/authentication.html
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		// if (! function_exists('user_id') || ! empty($this->config->failNoAuth))
		// {
		// 	throw new FilesException(lang('Files.noAuth'));
		// }
	}

	//--------------------------------------------------------------------

	/**
	 * Handles the final display of files based on $data.
	 *
	 * @return string
	 */
	public function display(): string
	{
		// Apply any defaults for missing metadata
		$this->setDefaults();

		// Theme::add_js(
        //     [
        //         '/resources/metronic/js/pages/custom/companies/outils.companies.js'
        //     ]
        // );

		// Get the Files
		if (! isset($this->data['files']))
		{
			// Apply a target user
			if ($this->data['userId'])
			{
				$this->model->whereUser($this->data['userId']);
			}

			// Apply any requested search filters
			if ($this->data['search'])
			{
				$this->model->like('filename', $this->data['search']);
			}

			// Sort and order
			$this->model->orderBy($this->data['sort'], $this->data['order']);

			// Paginate non-select formats
			if ($this->data['format'] !== 'select')
			{
				$this->setData([
					'files' => $this->model->paginate($this->data['perPage'], 'default', $this->data['page']),
					'pager' => $this->model->pager,
				], true);
			}
			else
			{
				$this->setData([
					'files' => $this->model->findAll()
				], true);
			}
		}
		$this->data['html']    = '';
		$this->data['theme_admin']    = 'metronic';
		$this->data['paramJs'] =  [
            'base_url'       => site_url(),
			'current_url'    => current_url(),
			'basePath'       => '\/',
            'baseController' => base_url('/' . env('app.areaAdmin') ),
            'segementAdmin'  => env('app.areaAdmin'),
            'startUrl'       => '\/' . env('app.areaAdmin')
		];
		$this->data['menu'] =  [];

		// AJAX calls skip the wrapping
		if ($this->data['ajax'])
		{
			return view('Adnduweb\Ci4Admin\Views\Formats\\' . $this->data['format'], $this->data);
		}

		return view('Adnduweb\Ci4Medias\Views\index', $this->data);
	}

	//--------------------------------------------------------------------

	/**
	 * Lists of files; if global listing is not permitted then
	 * falls back to user().
	 *
	 * @return RedirectResponse|string
	 */
	public function index()
	{
		// // Check for list permission
		// if (! $this->model->mayList())
		// {
		// 	return $this->user();
		// }

		return $this->display();
	}

	/**
	 * Filters files for a user (defaults to the current user).
	 *
	 * @param string|integer|null $userId ID of the target user
	 *
	 * @return ResponseInterface|ResponseInterface|string
	 */
	public function user($userId = null)
	{
		// Figure out user & access
		$userId = $userId ?? user_id() ?? 0;

		// Not logged in
		if (! $userId)
		{
			// Check for list permission
			if (! $this->model->mayList())
			{
				return $this->failure(403, lang('Permits.notPermitted'));
			}

			$this->setData([
				'access'   => 'display',
				'title'    => 'All Files',
				'username' => '',
			]);
		}
		// Logged in, looking at another user
		elseif ($userId != user_id())
		{
			// Check for list permission
			if (! $this->model->mayList())
			{
				return $this->failure(403, lang('Permits.notPermitted'));
			}

			$this->setData([
				'access'   => $this->model->mayAdmin() ? 'manage' : 'display',
				'title'    => 'User Files',
				'username' => 'User',
			]);
		}
		// Looking at own files
		else
		{
			$this->setData([
				'access'   => 'manage',
				'title'    => 'My Files',
				'username' => 'My',
			]);
		}

		$this->setData([
			'userId' => $userId,
			'source' => 'user/' . $userId,
		]);

		return $this->display();
	}

	//--------------------------------------------------------------------

	/**
	 * Display the Dropzone uploader.
	 *
	 * @return ResponseInterface|string
	 */
	public function new()
	{
		// Check for create permission
		if (! $this->model->mayCreate())
		{
			return $this->failure(403, lang('Permits.notPermitted'));
		}

		return view('Adnduweb\Ci4Admin\Views\new');
	}

	/**
	 * Displays or processes the form to rename a file.
	 *
	 * @param string|null $fileId
	 *
	 * @return ResponseInterface|string
	 */
	public function rename($fileId = null)
	{
		// Load the request
		$fileId = $this->request->getGetPost('file_id') ?? $fileId;
		$file   = $this->model->find($fileId);

		// Handle missing info
		if (empty($file))
		{
			return $this->failure(400, lang('Files.noFile'));
		}

		// Check for form submission
		if ($filename = $this->request->getGetPost('filename'))
		{
			// Update the name
			$file->filename = $filename;
			$this->model->save($file);

			// AJAX requests are blank on success
			return $this->request->isAJAX()
				? ''
				: redirect()->back()->with('message', lang('Files.renameSuccess', [$filename]));
		}

		// AJAX skips the wrapper
		return view(
			$this->request->isAJAX() ? 'Adnduweb\Ci4Admin\Views\Forms\rename' : 'Adnduweb\Ci4Admin\Views\rename',
			[
				'config' => $this->config,
				'file'   => $file,
			]
		);
	}

	/**
	 * Deletes a file.
	 *
	 * @param string $fileId
	 *
	 * @return ResponseInterface
	 */
	public function delete($fileId)
	{
		$file = $this->model->find($fileId);
		if (empty($file))
		{
			return $this->failure(400, lang('Files.noFile'));
		}
		if (! $this->model->mayDelete($file))
		{
			return $this->failure(403, lang('Permits.notPermitted'));
		}

		if ($this->model->delete($fileId))
		{
			return redirect()->back()->with('message', lang('Files.deleteSuccess'));
		}

		return $this->failure(400, implode('. ', $this->model->errors()));
	}

	/**
	 * Handles bulk actions.
	 *
	 * @return ResponseInterface
	 */
	public function bulk(): ResponseInterface
	{
		// Load post data
		$post = $this->request->getPost();

		// Harvest file IDs and the requested action
		$action  = '';
		$fileIds = [];
		foreach ($post as $key => $value)
		{
			if (is_numeric($value))
			{
				$fileIds[] = $value;
			}
			else
			{
				$action = $key;
			}
		}

		// Make sure some files where checked
		if (empty($fileIds))
		{
			return $this->failure(400, lang('Files.noFile'));
		}

		// Handle actions
		if (empty($action))
		{
			return $this->failure(400, 'No valid action');
		}

		// Bulk delete request
		if ($action === 'delete')
		{
			$this->model->delete($fileIds);
			return redirect()->back()->with('success', 'Deleted ' . count($fileIds) . ' files.');
		}

		// Bulk export of some kind, match the handler
		if (! $handler = handlers('Exports')->where(['slug' => $action])->first())
		{
			return $this->failure(400, 'No handler found for ' . $action);
		}

		$export = new $handler();
		foreach ($fileIds as $fileId)
		{
			if ($file = $this->model->find($fileId))
			{
				$export->setFile($file->object->setBasename($file->filename));
			}
		}

		try
		{
			$result = $export->process();
		}
		catch (ExportsException $e)
		{
			return $this->failure(400, $e->getMessage());
		}

		alert('success', 'Processed ' . count($fileIds) . ' files.');
		return $result;
	}

	/**
	 * Receives uploads from Dropzone.
	 *
	 * @return ResponseInterface|string
	 */
	public function upload()
	{
		// Check for create permission
		if (! $this->model->mayCreate())
		{
			return $this->failure(403, lang('Permits.notPermitted'));
		}

		// Verify upload succeeded
		$upload = $this->request->getFile('file');
		if (empty($upload))
		{
			return $this->failure(400, lang('Files.noFile'));
		}
		if (! $upload->isValid())
		{
			return $upload->getErrorString() . '(' . $upload->getError() . ')';
		}

		// Check for chunks
		if ($this->request->getPost('chunkIndex') !== null)
		{
			// Gather chunk info
			$chunkIndex  = $this->request->getPost('chunkIndex');
			$totalChunks = $this->request->getPost('totalChunks');
			$uuid        = $this->request->getPost('uuid');

			// Check for chunk directory
			$chunkDir = WRITEPATH . 'uploads/' . $uuid;
			if (! is_dir($chunkDir) && ! mkdir($chunkDir, 0775, true))
			{
				throw FilesException::forChunkDirFail($chunkDir);
			}

			// Move the file
			$upload->move($chunkDir, $chunkIndex . '.' . $upload->getExtension());

			// Check for more chunks
			if ($chunkIndex < $totalChunks - 1)
			{
				session_write_close();
				return '';
			}

			// Merge the chunks
			$path = $this->mergeChunks($chunkDir);
		}

		// Get additional post data to pass to model
		$data = $this->request->getPost();
		$data['filename']   = $data['filename'] ?? $upload->getClientName();
		$data['clientname'] = $data['clientname'] ?? $upload->getClientName();

		// Accept the file
		$file = $this->model->createFromPath($path ?? $upload->getRealPath(), $data);

		if ($this->request->isAJAX())
		{
			session_write_close();
			return '';
		}

		return redirect()->back()->with('message', lang('File.uploadSucces', [$file->clientname]));
	}

	/**
	 * Merges all chunks in a target directory into a single file, returns the file path.
	 *
	 * @return string
	 *
	 * @throws FilesException
	 */
	protected function mergeChunks($dir): string
	{
		helper('filesystem');
		helper('text');

		// Get chunks from target directory
		$chunks = get_filenames($dir, true);
		if (empty($chunks))
		{
			throw FilesException::forNoChunks($dir);
		}

		// Create the temp file
		$tmpfile = tempnam(sys_get_temp_dir(), random_string());
		log_message('debug', 'Merging ' . count($chunks) . ' chunks to ' . $tmpfile);

		// Open temp file for writing
		$output = @fopen($tmpfile, 'ab');
		if (! $output)
		{
			throw FilesException::forNewFileFail($tmpfile);
		}

		// Write each chunk to the temp file
		foreach ($chunks as $file)
		{
			$input = @fopen($file, 'rb');
			if (! $input)
			{
				throw FilesException::forWriteFileFail($tmpfile);
			}

			// Buffered merge of chunk
			while ($buffer = fread($input, 4096))
			{
				fwrite($output, $buffer);
			}

			fclose($input);
		}

		// close output handle
		fclose($output);

		return $tmpfile;
	}

	/**
	 * Processes Export requests.
	 *
	 * @param string         $slug   The slug to match to Exports attribute
	 * @param string|integer $fileId
	 *
	 * @return ResponseInterface
	 */
	public function export(string $slug, $fileId): ResponseInterface
	{
		// Match the export handler
		$handler = handlers('Exports')->where(['slug' => $slug])->first();
		if (empty($handler))
		{
			alert('warning', 'No handler found for ' . $slug);
			return redirect()->back();
		}

		// Load the file
		$file = $this->model->find($fileId);
		if (empty($file))
		{
			alert('warning', lang('Files.noFile'));
			return redirect()->back();
		}

		// Pass to the handler
		$export   = new $handler($file->object);
		$response = $export->setFilename($file->filename)->process();

		// If the handler returned a response then we're done
		if ($response instanceof ResponseInterface)
		{
			return $response;
		}

		return redirect()->back();
	}

	/**
	 * Outputs a file thumbnail directly as image data.
	 *
	 * @param string|integer $fileId
	 *
	 * @return ResponseInterface
	 */
	public function thumbnail($fileId): ResponseInterface
	{
		if ($file = $this->model->find($fileId))
		{
			$path = $file->getThumbnail();
		}
		else
		{
			$path = File::locateDefaultThumbnail();
		}

		return $this->response->setHeader('Content-type', 'image/jpeg')->setBody(file_get_contents($path));
	}

	//--------------------------------------------------------------------

	/**
	 * Handles failures.
	 *
	 * @param int $code
	 * @param string $message
	 * @param boolean|null $isAjax
	 *
	 * @return ResponseInterface|RedirectResponse
	 */
	protected function failure(int $code, string $message, bool $isAjax = null): ResponseInterface
	{
		log_message('debug', $message);

		if ($isAjax ?? $this->request->isAJAX())
		{
			return $this->response
				->setStatusCode($code)
				->setJSON(['error' => $message]);
		}

		return redirect()->back()->with('error', $message);
	}

	/**
	 * Sets a value in $this->data, overwrites optional.
	 *
	 * @param array<string, mixed> $data
	 * @param boolean $overwrite
	 *
	 * @return $this
	 */
	protected function setData(array $data, bool $overwrite = false): self
	{
		if ($overwrite)
		{
			$this->data = array_merge($this->data, $data);
		}
		else
		{
			$this->data = array_merge($data, $this->data);
		}

		return $this;
	}

	/**
	 * Merges in the default metadata.
	 *
	 * @return $this
	 */
	protected function setDefaults(): self
	{
		return $this->setData([
			'source'   => 'index',
			'layout'   => 'public',
			'files'    => null,
			'selected' => explode(',', $this->request->getVar('selected') ?? ''),
			'userId'   => null,
			'username' => '',
			'ajax'     => $this->request->isAJAX(),
			'search'   => $this->request->getVar('search'),
			'sort'     => $this->getSort(),
			'order'    => $this->getOrder(),
			'format'   => $this->getFormat(),
			'perPage'  => $this->getPerPage(),
			'page'     => $this->request->getVar('page'),
			'pager'    => null,
			//'access'   => $this->model->mayAdmin() ? 'manage' : 'display',
			'access'   => 'manage',
			'exports'  => $this->getExports(),
			'bulks'    => handlers()->where(['bulk' => 1])->findAll(),
		]);
	}

	/**
	 * Determines the sort field.
	 *
	 * @return string
	 */
	protected function getSort(): string
	{
		// Check for a request, then load from Settings
		$sorts = [
			$this->request->getVar('sort'),
			service('settings')->filesSort,
		];

		foreach ($sorts as $sort)
		{
			// Validate
			if (in_array($sort, $this->model->allowedFields)) // @phpstan-ignore-line
			{
				// Update user setting with the new preference
				service('settings')->filesSort = $sort;
				return $sort;
			}
		}

		return 'filename';
	}

	/**
	 * Determines the sort order.
	 *
	 * @return string
	 */
	protected function getOrder(): string
	{
		// Check for a request, then load from Settings
		$orders = [
			$this->request->getVar('order'),
			service('settings')->filesOrder,
		];

		foreach ($orders as $order)
		{
			$order = strtolower($order);

			// Validate
			if (in_array($order, ['asc', 'desc']))
			{
				// Update user setting with the new preference
				service('settings')->filesOrder = $order;
				return $order;
			}
		}

		return 'asc';
	}

	/**
	 * Determines items per page.
	 *
	 * @return int
	 */
	protected function getPerPage(): int
	{
		// Check for a request, then load from Settings
		$nums = [
			$this->request->getVar('perPage'),
			service('settings')->perPage,
		];

		foreach ($nums as $num)
		{
			// Validate
			if (is_numeric($num) && (int) $num > 0)
			{
				// Update user setting with the new preference
				service('settings')->perPage = $num;
				return $num;
			}
		}

		return 10;
	}

	/**
	 * Determines the display format.
	 *
	 * @return string
	 */
	protected function getFormat(): string
	{
		// Check for a request, then load from Settings, fallback to the config default
		$formats = [
			$this->request->getVar('format'),
			service('settings')->filesFormat,
			$this->config->defaultFormat,
		];

		foreach ($formats as $format)
		{
			// Validate
			if (in_array($format, ['cards', 'list', 'select']))
			{
				// Update user setting with the new preference
				service('settings')->filesFormat = $format;
				return $format;
			}
		}

		return 'cards';
	}

	/**
	 * Gets Export handlers indexed by the extension they support.
	 *
	 * @return array<string, array>
	 */
	protected function getExports(): array
	{
		$exports = [];
		foreach (handlers('Exports')->findAll() as $class)
		{
			$attributes = handlers()->getAttributes($class);

			// Add the class name for easy access later
			$attributes['class'] = $class;

			foreach (explode(',', $attributes['extensions']) as $extension)
			{
				$exports[$extension][] = $attributes;
			}
		}

		return $exports;
	}
}
