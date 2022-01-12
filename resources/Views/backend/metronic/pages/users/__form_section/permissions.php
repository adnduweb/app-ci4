<?php foreach ($form->auth_groups_users as $groups) { ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<td><?= ucfirst($groups->group->name); ?></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($permissions as $permission) { ?>
				<tr>
					<td>Handle: <?= ucfirst($permission->name); ?> <br /><em><?= $permission->description; ?></em></td>
					<td>
						<?php if (empty($permissionByIdGroupGroup[$groups->group_id])) { ?>
							<?php if ($groups->group_id == '1') { ?>
								---
							<?php } else { ?>
								<label class="checkbox checkbox-success <?= ($groups->group_id == '1') ? 'checkbox-success' : '' ?>">
									<input type="checkbox" name="permission_group[]" class="permission_group id_permission_group_<?= $groups->group_id; ?>" value="<?= $form->id; ?>|<?= $permission->id; ?>">
									<span></span>
								</label>
							<?php } ?>
						<?php } else { ?>
							<?php if (in_array($permission->id, $permissionByIdGroupGroup[$groups->group_id])) { ?>
								<label class="checkbox checkbox-tick checkbox-disabled <?= isset($permissionByIdGroupGroup[$groups->group_id][$permission->id]) ? 'checkbox-success' : '' ?>">
									<input disabled="disabled" type="checkbox" class="permission_group" <?= isset($permissionByIdGroupGroup[$groups->group_id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
									<span></span>
								</label>
							<?php } else { ?>
								<?php if (!empty($permissionByIdGroupGroupUser[$form->id]) && in_array($permission->id, $permissionByIdGroupGroupUser[$form->id])) { ?>
									<label class="checkbox checkbox-success <?= isset($permissionByIdGroupGroupUser[$form->id][$permission->id]) ? 'checkbox-success' : '' ?>">
										<input type="checkbox" class="permission_group" <?= isset($permissionByIdGroupGroupUser[$form->id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
										<span></span>
									</label>
								<?php } else { ?>
									<label class="checkbox  checkbox-success <?= isset($permissionByIdGroupGroup[$groups->group_id][$permission->id]) ? 'checkbox-success' : '' ?>">
										<input type="checkbox" class="permission_group" <?= isset($permissionByIdGroupGroup[$groups->group_id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
										<span></span>
									</label>
								<?php } ?>
							<?php } ?>
						<?php } ?>

					</td>
				</tr>
			<?php }  ?>
		</tbody>
	</table>
<?php } ?>