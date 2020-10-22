<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'JSON-RPC server';

?>

<div class="site-index">
    <p>The server receives requests from another (client) domain in JSON-RPC format, then parses it, evaluates and sends a response.</p>
    <p>All requests come to <?= HTML::a('this route', ['site/api']) ?>.</p>
</div>
