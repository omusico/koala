<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * github api列表
 * 
 * https://developer.github.com/v3/
 * https://api.github.com/
 */
$callbackUrl = '';

//
$cfg['code_search_url'] = array(
	'url'=>'https://api.github.com/search/code'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=> array('q','type','page','per_page','sort'),
	);
$cfg['issue_search_url'] = array(
	'url'=>'https://api.github.com/search/issues'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=> array('q','type','page','per_page','sort'),
	);
$cfg['organization_repositories_url'] = array(
	'url'=>'https://api.github.com/orgs/{org}/repos'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=> array('type','page','per_page','sort'),
	);
$cfg['organization_url'] = array(
	'url'=>'https://api.github.com/orgs/{org}'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array(),
	);
$cfg['public_gists_url'] = array(
	'url'=>'https://api.github.com/gists/public'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array(),
	);
$cfg['repository_url'] = array(
	'url'=>'https://api.github.com/repos/{owner}/{repo}'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array(),
	);
$cfg['user_url'] = array(
	'url'=>'https://api.github.com/users/{user}'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array(),
	);
$cfg['user_repositories_url'] = array(
	'url'=>'https://api.github.com/users/{user}/repos'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('type','page','per_page','sort'),
	);
$cfg['user_search_url'] = array(
	'url'=>'https://api.github.com/search/users'
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('q','type','page','per_page','sort'),
	);