# Shardimage PHP package

## Introduction

Official PHP package for using Shardimage application.

## Installation

### Install With Composer

```bash
composer require shardimage/shardimage-php
```

or add

```json
shardimage/shardimage-php:"^1.0"
```

to your `composer.json` file and run update.

## Quick start

Simple examples to use the package. For more details, please read our official documentation >>>

### Configuring the Client

Configure the Client with information from our website to make connection with the Shardimage API.

```php
use shardimage\shardimagephp\auth\Client;

$client = new Client([
    'apiKey' => '<apiKey>',             //key to use the API or the image serving
    'apiSecret' => '<apiSecret>',       //secret to use the API
    'imageSecret' => '<imageSecret>'    //secret to gain more security on image serving
    'cloudId' => '<cloudId>',           //default configuration for cloud ID, it can be overwritten in later usage
]);
```

### Getting access datas

Your `apiKey` and `apiSecret` is available on [Shardimage api](https://shardimage.com/api) page.

Access token can be created through Shardimage API, it requires a configured client with `apiKey` and `apiSecret`.

```php
use shardimage\shardimagephp\models\accesstoken\ImageUrlAccessToken;

$accessToken = new ImageUrlAccessToken();
$accessToken->expiry = time() + 3600;
$accessToken->limit = 1000;
$accessToken->extra = [
    'secret' => 'secretString', //<apiAccessTokenSecret>
];

$accessToken = $client->getAccessTokenService()->create($accessToken);
if ($accessToken instanceof ImageUrlAccessToken) {
    echo $accessToken->id; //<apiAccessToken>
}
```

Now we can configure an another Client for token image hosting:

```php
use shardimage\shardimagephp\auth\Client;

$tokenClient = new Client([
    'apiAccessToken' => <apiAccessToken>,
    'apiAccessTokenSecret' => <apiAccessTokenSecret>, //optional, 
]);
```

### Manage clouds with API

To upload and store images, cloud must to be created.

```php
use shardimage\shardimagephp\models\cloud\Cloud;
use shardimage\shardimagephp\services\CloudService;

$cloud = new Cloud([
    'name' => 'First Cloud',
    'description' => 'My first Shardimage cloud ever. Awesome!',
]);
```

You can add features to your cloud to make it efficient and secure! To view the full list of our features, please check the documentation >>>

Notice: The `deliverySecureUrl` settings will work only, if you set up the client with the security information: image secret hash or access token/acces token secret.

```php
$cloud->settings = [
    //...
    "deliverySecureUrl" => [
        "status" => true    //securing image hosting
    ],
    //...
];
```

Send to the API to create it.

```php
$cloud = $client->getCloudService()->create($cloud);
```

If you already have clouds, you can list them:

```php
use shardimage\shardimagephp\models\cloud\IndexParams;

$indexParams = new IndexParams();
$indexParams->nextPageToken = 0;
$indexParams->projections = [   //with projections parameter, we have the chance to narrow down the returning data.
    IndexParams::PROJECTION_NO_BACKUP,
    IndexParams::PROJECTION_NO_FIREWALL,
];

$response = $client->getCloudService()->index($indexParams);
```

### Manage images with API

To upload images to a cloud, or list from it, we need to use the ID of the cloud. The Shardimage PHP package is capable to upload images through single or multithreads, if you have big amount of pictures.

Single thread:
```php
$file = __DIR__ . '/' . $file;
$fileName = 'Example';
$result = $client->getUploadService()->upload([
    'file' => $file;
    'cloudId' => <cloudId>;
], [    //optional parameters
    'publicId' => $fileName,
    'tags' => [
        'example',
        'dump'
    ],
]);
```

If everything goes alright, the `$result` variable will contain `shardimage\shardimagephp\models\image\Image` object with the uploaded image datas.

Multithread upload is very similar, we need to turn on the `defer` option before the upload. Turning it off will send the collected datas.

```php
$files = [
    'file1.jpg',
    'file2.jpg',
    'file3.png',
    'file4.webp',
    'file5.gif',
];
$client->defer(true); //turning on
foreach ($files as $file) {
    $client->getUploadService()->upload([
        'file' => $file,
    ], [
        'tags' => [
            'batch',
            'examples'
        ],
    ]);
}
$result = $client->defer(false); //without turning off, nothing will happen
```

Unwanted pictures can be deleted from the system with two methods. Simple delete will delete one image by it's public ID and the cloud ID.
```php
$client->getImageService()->delete([
    'publicId' => <publicId>,
    'cloudId' => <cloudId>,
]);
```
Other way is to delete images by their tags. In this case every images with the given tags will be deleted from the target cloud.
```php
$client->getImageService()->delete([
    'cloudId' => <cloudId>,
    'tag' => '<tag>',
]);
```

### Hosting images

Hosting the uploaded images with the packgate is basically generating their URL. Using the `UrlService` class you can build up remote image URLs also to serve them through the Shardimage.
Practically, the Shardimage will store only the original uploaded image. Every modification, transformation, conversion will applied through URL rules or cloud settings. For further information, please check the documentation >>>

Example for generation URL for stored image:
```php
$transformation = Transformation::create();
$transformation->width(200)->height(200)->group();
$url = $client->getUrlService()->create([
    'cloudId' => <cloudId>,
    'publicId' => <publicId>,
], [
    'transformation' => $transformation,
    'security' => 'basic',
]);
echo $url; //https://img.shardimage.com/<cloudId>/s-b3:<securehash>/w:200_h:200/i/<publicId>
```

Basic security hash will be added to the URL only if you set up the `imageSecret` in your client config.

## Changelog

All notable changes to this project will be documented in the [CHANGELOG](CHANGELOG.md) file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## License

[Read more >>](https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md)

## Links

 - [Shardimage](https://shardimage.com)
 - [Shardimage documentation](https://developers.shardimage.com)
 - [Shardimage blog](https://shardimage.com/blog)