<?php

declare(strict_types=1);

/*
 * This file is part of Ruta.
 *
 * (c) Jose Quintana <joseluisq.net>
 *
 * This source file is subject to the Apache 2.0 and MIT licenses which are bundled
 * with this source code in the files LICENSE-APACHE and LICENSE-MIT respectively.
 */

use Ruta\Header;
use Ruta\Response;
use Ruta\Status;

beforeEach(function () {
    $this->response   = new Response();
    $this->reflection = new \ReflectionClass(Response::class);
});

test('status: should contain the OK status code by default', function () {
    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($http_status)->toBe($expected_http_status);
});

test('status: should still be the previous value when using wrong status', function () {
    $response             = $this->response->status(1970);
    expect($response)->toBe($this->response);

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($http_status)->toBe($expected_http_status);
});

test('status: should add or update the corresponding status', function () {
    $this->response->status(Status::OK);
    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($expected_http_status)->toBe($http_status);

    $this->response->status(Status::NotFound);
    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::NotFound . ' ' . Status::text(Status::NotFound);
    expect($expected_http_status)->toBe($http_status);
});

test('headers: should be empty by default', function () {
    $reflection_prop = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers          = $reflection_prop->getValue($this->response);
    expect($http_headers)->toBeArray()->toBeEmpty();
});

test('header: should add or update the corresponding header', function () {
    $response = $this->response->header(Header::ContentType, 'application/json');
    expect($response)->toBe($this->response);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::ContentType   => 'application/json'];
    expect($http_headers)->toMatchArray($expected_headers);

    $this->response->header(Header::ContentLength, '1000');
    $reflection_prop  = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers            = $reflection_prop->getValue($this->response);
    $expected_headers        = array_merge($expected_headers, [Header::ContentLength => '1000']);
    expect($http_headers)->toMatchArray($expected_headers);
});

test('text: should end an HTTP response in plain text', function () {
    $this->response->text('abcde');

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($expected_http_status)->toBe($http_status);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::ContentType   => 'text/plain;charset=utf-8', Header::ContentLength => '5'];
    expect($http_headers)->toMatchArray($expected_headers);
});

test('json: should end an HTTP response in JSON', function () {
    $this->response->json(['data' => 1234]);

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($expected_http_status)->toBe($http_status);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::ContentType   => 'application/json;charset=utf-8', Header::ContentLength => '13'];
    expect($http_headers)->toMatchArray($expected_headers);
});

test('xml: should end an HTTP response in XML', function () {
    $this->response->xml('<data>1234</data>');

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($expected_http_status)->toBe($http_status);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::ContentType   => 'application/xml;charset=utf-8', Header::ContentLength => '17'];
    expect($http_headers)->toMatchArray($expected_headers);
});

test('html: should end an HTTP response in HTML', function () {
    $this->response->html('<p>1234</p>');

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::OK . ' ' . Status::text(Status::OK);
    expect($expected_http_status)->toBe($http_status);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::ContentType   => 'text/html;charset=utf-8', Header::ContentLength => '11'];
    expect($http_headers)->toMatchArray($expected_headers);
});

test('redirect: should redirect to the corresponding URL permanently', function () {
    $redirect_url = 'http://localhost/xyz';
    $this->response->redirect($redirect_url);

    $reflection_prop = $this->reflection->getProperty('status');
    $reflection_prop->setAccessible(true);

    $http_status          = $reflection_prop->getValue($this->response);
    $expected_http_status = 'HTTP/1.1 ' . Status::PermanentRedirect . ' ' . Status::text(Status::PermanentRedirect);
    expect($expected_http_status)->toBe($http_status);

    $reflection_prop   = $this->reflection->getProperty('headers');
    $reflection_prop->setAccessible(true);

    $http_headers             = $reflection_prop->getValue($this->response);
    $expected_headers         = [Header::Location   => $redirect_url, Header::ContentLength => '0'];
    expect($http_headers)->toMatchArray($expected_headers);
});
