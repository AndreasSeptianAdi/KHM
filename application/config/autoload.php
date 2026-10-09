<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();

$autoload['libraries'] 	= array('database', 'session', 'form_validation','pagination');

$autoload['drivers'] = array();

$autoload['helper'] 	= array('url', 'inflector', 'html', 'text', 'string', 'form', 'site', 'date');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('mainmodel','usermodel','reportmodel');
