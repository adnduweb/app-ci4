<?php

namespace Adnduweb\Ci4Core\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CompressFilter implements FilterInterface
{

  public function before(RequestInterface $request, $params = null)
  {

    // //On detecte si le fonrt est accessible
    // if (service('settings')->activer_front == false) {

    //   if ($request->uri->getSegment(1) != CI_AREA_ADMIN) {
    //     return redirect()->to(route_to('dashboard'));
    //   }
    // }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {

    //echo 'fdgsdgsdfg'; exit;
    // ON compresse le front HTML pas
    $nameUri = (implode('_', $request->uri->getSegments()));

   // if ($request->uri->getSegment(1) != CI_AREA_ADMIN) {

      // Do something here
      if (env('CI_ENVIRONMENT') == 'production') {
        $re = '%# Collapse whitespace everywhere but in blacklisted elements.
              (?>             # Match all whitespans other than single space.
                [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
              | \s{2,}        # or two or more consecutive-any-whitespace.
              ) # Note: The remaining regex consumes no text at all...
              (?=             # Ensure we are not in a blacklist tag.
                [^<]*+        # Either zero or more non-"<" {normal*}
                (?:           # Begin {(special normal*)*} construct
                  <           # or a < starting a non-blacklist tag.
                  (?!/?(?:textarea|pre|script)\b)
                  [^<]*+      # more non-"<" {normal*}
                )*+           # Finish "unrolling-the-loop"
                (?:           # Begin alternation group.
                  <           # Either a blacklist start tag.
                  (?>textarea|pre|script)\b
                | \z          # or end of file.
                )             # End alternation group.
              )  # If we made it here, we are not in a blacklist tag.
              %Six';

        $options = [
          'max-age'  => 300,
          's-maxage' => 900
        ];
        $response->setCache($options);

        $new_buffer = preg_replace($re, " ", $response->getBody());
        $response->setBody($new_buffer);
      }
   // }
  }
}
