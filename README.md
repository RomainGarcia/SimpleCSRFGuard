Simple CSRF Guard
=================

# Description

Designed to provide a simple implementation of a CSRF protection in a PHP project.

# Usage

```php
	<?php
	//Instantiate the class
	require_once("SimpleCSRFGuard.class.php");
	$csrfGuard = new SimpleCSRFGuard();

	//Generate a CSRF token linked to the user's session
	$csrfGuard->generateToken();

	//validate a CSRF token
	$csrfGuard->validateToken($tokenToValidate);
```

The session parameter name and the maximium of stored tokens can be modified when the class is instantiated:

```php
	<?php
	$csrfGuard = new SimpleCSRFGuard("session_parameter_name", max_tokens);
```

For a simple example of implementation, please check the "example.php" file.

# Licence

Author:	Romain Garcia

Copyright 2018, Romain Garcia

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
