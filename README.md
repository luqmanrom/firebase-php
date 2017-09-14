# Firebase PHP Wrapper

This package makes the authentication and the basic CRUD
operation on Firebase Database as simple as possible. 
For now, it supports both Guzzle 5 and Guzzle 6. 


## Installation

The easiest way it via Composer

```
composer require geckob/firebase
```

## Usages


### 1. Authentication

**1.1 Generate Service Account secret file**

This package supported authentication using secrets file generated in the Service Account page.

To generate the secret file, follow this steps

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Choose your project
3. Click the gear icon and go to Project Settings
4. Click the Service Accounts tab
5. Scroll down and click "Generate New Private Key" button. Save it to somewhere secure but 
	accessible for your internal server

**1.2 Use the secret file to authenticate**

```php
    $firebase = new \Geckob\Firebase\Firebase('path_to_your_secret_file.json');
```
### 2. CRUD Operation

The CRUD operation on Firebase Database is based on the [Firebase REST API Docs](https://www.firebase.com/docs/rest-api.html).

Assuming the authentication is succesfully done,

```php
// Set the parent node. 
$firebase = $firebase->setPath('bookings/');

// Create a new node with key = test and value = testValue. 
// If the node already exist, it will update the value
$firebase->set('test','testValue');

// Support multiple nodes, if it doesnt exist, it will create the node
$firebase->set('testObject/testKey', 'testValueObject');


// Same as set but without keys. This requires to call setPath first to identify the parent
$firebase->push([
	'test'  => 'value',
	'test1' => 'value1'
]);

// Get the value of node with key = test
$firebase->get('test');

// Get the value of using multilevel key
$firebase->get('testObject/testKey');




// Delete the node with key = test
$firebase->delete('test');

// Delete the multilevel node and all it's children
$firebase->delete('testObject/testKey');


```

// 

## Others

This package works perfectly fine for my use case for now. Should you have any other
use cases that requires me to extend the features, or suggestions how this package
can be improved, feel free to open issues or email me at luqmanrom@gmail.com


## License 

#### The MIT License (MIT)
```
Copyright (c) 2012-2016 Tamas Kalman

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
```	



