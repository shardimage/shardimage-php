# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0-alpha54] - 2021-10-11
### Fixed
 - The MinFresh option is fixed to `hc-min-fresh` from `hc-minfresh`.

## [1.0.0-alpha53] - 2021-09-29
### Added
 - Added `nop` URL parameters to `Text` factory.
 - The `nop` transformation will be default text transformation, if there is no other transformation given.

## [1.0.0-alpha52] - 2021-06-14
### Added
 - Added `frame` and `sec` URL parameters to `Transformation` factory.

## [1.0.0-alpha51] - 2021-04-21
### Fixed
 - IndexIterator `rewindAll` function fixed.

## [1.0.0-alpha50] - 2021-03-25
### Add
 - Added `IndexIterator` class to make API request more easy.

## [1.0.0-alpha49] - 2021-03-02
### Add
 - Added `s-b4` secure hash type.
### Change
 - Basic security hash is `s-b4` from now.

## [1.0.0-alpha48] - 2021-01-20
### Change
 - Image hostname parsing moved to `UrlService` from `Client`. From now it's possible to overwrite `Client` class's `imageHost`.
 - From now `UrlService` public functions will accept `imageHost` parameter in `$optParams` so the image host can be changed right at the URL creation.

## [1.0.0-alpha47] - 2020-08-05
### Fix
 - Fixing remote URL generation with adding URL encoding.

## [1.0.0-alpha46] - 2020-08-05
### Add
 - An image public ID from the same cloud can be added to `default_public_id` optional API parameter in URL creation. It will be rendered if the original image source is not available.

## [1.0.0-alpha45] - 2020-06-30
### Add
 - Documentation in `UploadService`.
 - Connection data validation in `Client`.

## [1.0.0-alpha44] - 2020-06-30
### Add
 - Added `allowOverride` to upload builder. If it's `true` it will allow override of the image if publicId already exists.

## [1.0.0-alpha43] - 2020-06-29
### Add
 - Added `xy` offset transformation to `Transformation` factory.

## [1.0.0-alpha42] - 2020-06-02
### Change
 - Change in PHP version, PHP 7.1 and above is supported.

## [1.0.0-alpha41] - 2020-06-02
### Fix
 - Fixing Unit test Client parameters.

## [1.0.0-alpha40] - 2020-06-02
### Add
 - URL size checking in the end of the URL generation.
 - URL size checking test.

## [1.0.0-alpha39] - 2020-05-21
### Add
 - Google fonts can be used in URL generation with `googleFonts` function in `Text` factory.

## [1.0.0-alpha38] - 2020-04-22
### Add
 - New fonts added to `Text` factory.
 - `space` and `lineSpace` functions added to `Text` factory.

## [1.0.0-alpha37] - 2020-03-26
### Add
 - `nofw` URL option added to Option factory.
 - `UploadBuilder` class added to support developer friendly image upload.

## [1.0.0-alpha36] - 2020-01-17
### Change
 - GET parameters at API request can be array.

## [1.0.0-alpha35] - 2019-12-05
### Add
 - Added `PasswordHashInterface` and `MixedShaPasswordHash`.
 - Added new tests for `MixedShaPasswordHash` object.
### Change
 - **[BC BREAK]** `s-token` URL parameter is changed to `s-token2` to provide better security.
 - The image URL access token extra password property can be `PasswordHashInterface` implemented object.

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
 - **[BC BREAK]** The `itemCount` and `storageSize` properties changed to `estimatedItemCount` and `estimatedStorageSize`.

## [1.0.0-alpha27] - 2019-10-17
### Add
 - Added `strictSecureHash()` function to `Option` factory.

## [1.0.0-alpha26] - 2019-09-20
### Change
 - **[BC BREAK]** Public ID is required during image upload.

### Add
 - `StringHelper` class for string functions.
 - `UploadHelper` class to provide image public ID generation opportunity.

## [1.0.0-alpha25] - 2019-08-21
### Fix
 - URL encode fixes

## [1.0.0-alpha24] - 2019-08-08
### Change
 - **[BC BREAK]** `DetailParams` class `GROUP_EGRESS` constant changed to `GROUP_NETWORK`

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
