<?php
/**
* Sets new column text alignment.
*
* @param user-name name of list owner
* @param list-id   id of list
* @param column-id id of column to change the align of
* @param new-align new column alignment (left, right or center)
*/
class SetColumnAlignJob extends GenericListJob
{
	public function execute()
	{
		$list = $this->getList();

		if (!in_array($this->getArgument('new-align'), ListService::getPossibleColumnAlign()))
			throw new SimpleException('Invalid column align: ' . $this->getArgument('new-align') . '.');

		$pos = ListService::getColumnPos($list, $this->getArgument('column-id'));

		$list->content->columns[$pos]->align = $this->getArgument('new-align');

		ListService::saveOrUpdate($list);
	}
}
