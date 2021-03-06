<?php
/**
* Sets list visibility.
*
* @param user-name      name of list owner
* @param list-id        id of list
* @param new-visibility whether to show the list to the public (1) or make it private (0)
*/
class SetListVisibilityJob extends GenericListJob
{
	public function execute()
	{
		$list = $this->getList();

		$list->visible = boolval($this->getArgument('new-visibility'));

		ListService::saveOrUpdate($list);
	}
}
