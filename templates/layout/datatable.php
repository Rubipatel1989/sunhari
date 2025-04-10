<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>
<?= $this->Html->css($home_url.'/dist/css/datagrid/datatables/datatables.bundle.css') ?>
<?= $this->Html->script($home_url.'/dist/libs/jquery/dist/jquery.min.js') ?>
<?= $this->Html->script($home_url.'/dist/libs/jquery/dist/app.min.js') ?>
<?= $this->Html->script($home_url.'/dist/libs/jquery/dist/app.init.js') ?>
<?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.bundle.js') ?>
<?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.export.js') ?>
<?= $this->Html->script('backend/dataTables.js') ?>
<?php
echo $this->fetch('content');
