# _Action Domain Responder_ Example

This example shows an ADR user interface subsystem, with the corresponding domain logic and data source elements, for a naive blogging system.

This is not a running example, in the sense that it cannot be dropped onto a web server and begin operating properly.

However, there is a full test suite in the `tests/` directory. (These are more properly considred integration rather than unit tests, but they will do for the purpose of this example.)  Issue `composer install` followed by `./vendor/bin/phpunit` to run the tests.

There is no authentication, authorization, or session mechanism included. While necessary in a real system, they would increase the complexity of the example and make it more difficult to discern the separation of concerns.

## _Action_

The _Action_ classes depend on 3rd-party HTTP Request and Response interfaces.

Each _Action_ picks apart the incoming request to pass individual typehinted _Domain_ method arguments. A differently-constructed _Domain_ might require a different input signature, such as a data transfer object or a catch-all array of all possible request values.

## _Domain_

The base _ApplicationService_ class protects all the "real" service methods behind the magic `__call()` method. This allows the service to implement some functionality common to all the service methods, such as exception handling, though it does get in the way of IDE auto-completion.

The _BlogService_ methods return a domain _Payload_ that wraps the domain results and includes a status indicator. This standardizes the domain return signature, makes the _BlogResponder_ work much more readable.

The domain logic uses a _Data Mapper_ for data source interactions (_BlogMapper_ et al.).

## _Responder_

Each _Responder_ calls a method corresponding to the domain _Payload_ status to build the HTTP Response.

The base _Responder_ class depends on a 3rd-party HTTP Request interface and Response object.

The base _BlogResponder_ class depends on a 3rd-party PHP-based _Template View_ system. The templates are located in `resources/templates/blog/`.
