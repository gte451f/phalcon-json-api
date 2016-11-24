<?php
/**
 * This set of basic tests illustrates how you can check various end points in your api
 * the expected format for these tests are ActiveModel
 *
 *
 * See the outputFormat property in your config.php file
 */
$I = new AcceptanceTester($scenario);
$I->wantTo('Test query abilities of all api end points');

$endpoints = array(
    'addresses',
    'customers',
    'users'
);

foreach ($endpoints as $endpoint) {
    $I->sendGet("$endpoint?limit=2");
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();

    $newID = $I->grabDataFromResponseByJsonPath("$.{$endpoint}[0].id");

    // test calling an individual resource
    $I->sendGet($endpoint . '/' . $newID[0]);
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();

    // test offsett
    $I->sendGet("$endpoint?limit=2&offset=2");
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();
    $I->seeResponseJsonMatchesJsonPath("$.{$endpoint}[*].id");

    // run searches side loading all records
    $I->sendGet("$endpoint?limit=2&offset=2&with=all");
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();
    $I->seeResponseJsonMatchesJsonPath("$.{$endpoint}[*].id");

    // run searches with NO side loaded records
    $I->sendGet("$endpoint?limit=2&offset=2&with=none");
    $I->seeResponseCodeIs(200);
    $I->seeResponseIsJson();
    $I->seeResponseJsonMatchesJsonPath("$.{$endpoint}[*].id");
}