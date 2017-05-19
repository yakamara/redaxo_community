<?php

// TODO:
// rex_ycom_user table ergaenzen
// gruppe hinzufügen

rex_sql_table::get(rex::getTable('article'))
    ->ensureColumn(new rex_sql_column('ycom_group_type', "ENUM('0','1','2','3')", false, '0'))
    ->ensureColumn(new rex_sql_column('ycom_groups', 'varchar(255)'))
    ->alter()
;

if($content = rex_file::get(rex_path::plugin('ycom', 'group', 'install/tablesets/yform_group.json')))
{
    rex_yform_manager_table_api::importTablesets($content);
}

if($content = rex_file::get(rex_path::plugin('ycom', 'group', 'install/tablesets/yform_group_user.json')))
{
    rex_yform_manager_table_api::importTablesets($content);
}
