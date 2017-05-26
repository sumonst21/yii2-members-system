<?php

/**
 * Creates a call for the method `yii\db\Migration::createTable()`
 */
/* @var $table string the name table */
/* @var $fields array the fields */
/* @var $foreignKeys array the foreign keys */
/* @var $tableOptions bool Adds tableOptions to set utf8_unicode_ci and InnoDB */

?>
<?php if (isset($tableOptions) && ($tableOptions === true)) { ?>
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

<?php } ?>
        $this->createTable('<?= $table ?>', [
<?php foreach ($fields as $field):
    if (empty($field['decorators'])): ?>
            '<?= $field['property'] ?>',
<?php else: ?>
            <?= "'{$field['property']}' => \$this->{$field['decorators']}" ?>,
<?php endif;
endforeach; ?>
        ]<?= (isset($tableOptions) && ($tableOptions === true)) ? ', $tableOptions' : '' ?>);

<?= $this->render('@vendor/yiisoft/yii2/views/_addForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
