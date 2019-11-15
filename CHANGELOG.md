# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0-alpha34] - 2019-11-15
### Change
 - Changed travis yaml file.

## [1.0.0-alpha33] - 2019-11-15
### Add
 - Added factory unit tests.
 - Added travis yaml file.
### Fix
 - Fixed Condition factory rendering function.

## [1.0.0-alpha32] - 2019-11-14
### Fix
 - Text factory:
   - `size` transformation parameter is fixed.
   - Rendering without transformation is fixed.

## [1.0.0-alpha31] - 2019-11-13
### Fix
 - Fixed access token - extra authentication setting and sending to API.

## [1.0.0-alpha30] - 2019-11-07
### Add
 - Added `tint` effect to Transformation factory.

## [1.0.0-alpha29] - 2019-11-06
### Add
 - Added image update function to the image service class. It can be used to change image tags and execute plugins on the image.
 - Added plugin constans to the Image model class.

## [1.0.0-alpha28] - 2019-10-22
### Change
 - The `itemCount` and `storageSize` properties changed to `estimatedItemCount` and `estimatedStorageSize`.

## [1.0.0-alpha27] - 2019-10-17
### Add
 - Added `strictSecureHash()` function to `Option` factory.

## [1.0.0-alpha26] - 2019-09-20
### Change
 - Public ID is required during image upload.

### Add
 - `StringHelper` class for string functions.
 - `UploadHelper` class to provide image public ID generation opportunity.

## [1.0.0-alpha25] - 2019-08-21
### Fix
 - URL encode fixes

## [1.0.0-alpha24] - 2019-08-08
### Change
 - `DetailParams` class `GROUP_EGRESS` constant changed to `GROUP_NETWORK`

## [1.0.0-alpha23] - 2019-07-18
### Fix
 - Fixing the response handler function in the client class.

## [1.0.0-alpha22] - 2019-07-10
### Change
 - Emptying the request variable is moved to `finally` block.

## [1.0.0-alpha21] - 2019-07-09
### Fix
 - Multipart error handling fixed.

## [1.0.0-alpha20] - 2019-07-04
### Add
 - Added implementation for Super backup log API endpoint.

## [1.0.0-alpha19] - 2019-06-06
### Add
 - Added `dumpService` property for dumping out the request and response data.

## [1.0.0-alpha18] - 2019-05-09
### Add
 - Added `page` transformation. Can be used for multi-page PDF documents.

## [1.0.0-alpha17] - 2019-04-30
### Change
 - **[BC BREAK]** Changed `nextPageToken` to `pageToken` in API request. Unchanged in `IndexParams` abstract class, so usage is unchanged however this change can break backward compatibility.

## [1.0.0-alpha16] - 2019-04-15
### Removed
 - Removed functions that are waiting to be optimized and completed.

## [1.0.0-alpha15] - 2019-04-05
### Fix
 - Fixed the token authentication header name.
### Add
 - Added license information to composer.json file.

## [1.0.0-alpha14] - 2019-04-03
### Change
 - Added url encoding to the http header option value.

## [1.0.0-alpha13] - 2019-04-03
### Add
 - Added `httpHeader` option and new function to add multiple options to the url.

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
