# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0-alpha12] - 2019-03-18
### Add
 - Added `createFetch` function to `UrlService` class to create fetched remote urls.

## [1.0.0-alpha11] - 2019-03-14
### Fix
 - Fixed `modify` function in `UploadService` class.
 - Removed functionality of `copy` function from `UploadService` class.

## [1.0.0-alpha10] - 2019-03-12
### Fix
 - `getToArrayAttributes()` function added to `AccessToken` and `Target` classes.

## [1.0.0-alpha9] - 2019-03-01
### Fix
 - Fixed remote url creating, `format` as optional parameter is no longer supported.

## [1.0.0-alpha8] - 2019-02-22
### Fix
 - Cleaning out stored content IDs after sending request.

## [1.0.0-alpha7] - 2019-02-22
### Fix
 - Add missing namespace.

## [1.0.0-alpha6] - 2019-02-22
### Add
 - Requests per branch is now limited by `shardimage\shardimagephp\auth\Client` class `batchLimit` property. Optional parameter, the client won't send the request if the limit is reached.
### Change
 - **[BC BREAK]** If case of error, service will throw response exception, not generating it from the response datas.

## [1.0.0-alpha5] - 2019-02-18
### Change
 - Comparing sent and recieved requests and their responses to detect not recieved data.

## [1.0.0-alpha4] - 2019-02-14
### Add
 - Added `timeout` property to client.

## [1.0.0-alpha3] - 2019-02-12
### Change
 - Change in error response handling

### Add
 - Licence file

## [1.0.0-alpha2] - 2019-02-11
### Change
 - Standardization of the bulk upload response.

## [1.0.0-alpha1]
 - Initial release
