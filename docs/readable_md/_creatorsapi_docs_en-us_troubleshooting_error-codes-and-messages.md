# Error Codes and Messages

Source: `_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.html`

# Error Codes and Messages

Creators API returns structured error responses that provide information about request validation failures, authentication issues, and server-side errors. All error messages are returned in English for all marketplaces.

## Error Response Structure

All errors follow a consistent JSON structure with these elements:

-   **Type:** The exception type identifier for clients to programmatically identify the exception (e.g., `ValidationException`).
    
-   **Message:** A human-readable description of the error to help you debug the issue.
    
-   **Reason (for ValidationException, AccessDeniedException, and UnauthorizedException):** A machine-readable code that categorizes the specific type of validation, access, or authentication error.
    
-   **Additional fields (context-dependent):** Some errors include additional fields like `resourceId`, `resourceType`, `fieldList`, or `retryAfterSeconds`.
    

### Example Error Response

Copy

```
{
  "type": "ValidationException",
  "message": "Partner tag in the request is invalid or is not mapped to the store associated with your credential.",
  "reason": "InvalidPartnerTag"
}
```

## Exception Types

Exception

HTTP Status Code

Description

UnauthorizedException

401 Unauthorized

Exception indicating missing or bad authentication for the operation.

ValidationException

400 Bad Request

The input fails to satisfy the constraints specified by the service. Use ValidationExceptionReason and fieldList to identify specific issues.

AccessDeniedException

403 Forbidden

User does not have sufficient access to perform this action.

ResourceNotFoundException

404 Not Found

Request references a resource which does not exist.

ThrottleException

429 Too Many Requests

Request was denied due to request throttling. Clients should implement exponential backoff and retry.

InternalServerException

500 Internal Server Error

Unexpected error during processing of request. Clients should retry with exponential backoff.

> It is also possible to submit a valid request and still have errors. In such cases, the HTTP Status Code is `200 Success`, however, the response might contain errors. For more information, refer [Processing of Errors](./_creatorsapi_docs_en-us_troubleshooting_processing-of-errors.md).

## HTTP Status Code Ranges

#### 4xx Client Errors

These errors indicate issues with the request sent to Creators API:

-   **400 Bad Request** - ValidationException (invalid input, missing fields, parsing errors)
-   **401 Unauthorized** - UnauthorizedException (missing or invalid authentication)
-   **403 Forbidden** - AccessDeniedException (insufficient permissions or ineligible account)
-   **404 Not Found** - ResourceNotFoundException (requested resource doesn't exist)
-   **429 Too Many Requests** - ThrottleException (rate limiting)

#### 5xx Server Errors

These errors indicate issues on the Creators API server side:

-   **500 Internal Server Error** - InternalServerException (unexpected server-side error)

## Error Reason Codes

The following sections provide detailed descriptions and example messages for each reason code.

### ValidationException Reasons

Reason Code

Description

Example Message

**UnknownOperation**

The operation requested is not recognized or does not exist

"The operation requested is invalid. Please verify that the operation name is typed correctly."

**CannotParse**

The request payload cannot be parsed as valid JSON

"Unable to parse the request payload. Please verify that the request body is valid JSON."

**FieldValidationFailed**

One or more request fields failed validation

"Request validation failed." (includes `fieldList` array with field names)

**InvalidAssociate**

The credential is not linked to the partner tag for the given marketplace

"Your credential is not linked to the partner tag in the request for the given Marketplace."

**InvalidPartnerTag**

The partner tag is invalid or not mapped to the store

"Partner tag in the request is invalid or is not mapped to the store associated with your credential."

**Other**

Other validation error not covered by specific reason codes

Varies based on the specific validation error encountered

### AccessDeniedException Reasons

Reason Code

Description

Example Message

**AssociateNotEligible**

The associate account does not meet the eligibility requirements to access the Creators API. The current eligibility criteria is that the account must have made 10 qualified sales in the trailing 30 days.

"Your account does not currently meet the eligibility requirements."

**AuthorizationFailed**

Authorization check failed for the requested operation

"Authorization check failed for the requested operation."

**Other**

Access denied for a reason not covered by specific codes

Varies based on the specific access denial reason

### UnauthorizedException Reasons

Reason Code

Description

Example Message

**TokenExpired**

The authentication token has expired. Fetch a new access token using your credentials.

"Authentication token has expired."

**InvalidToken**

The authentication token is invalid or malformed. Verify your token format and regenerate if necessary.

"The authentication token is invalid or malformed."

**InvalidIssuer**

The token issuer does not match the expected issuer. Ensure the credential version in your request header matches the region where the token was generated.

"The token issuer is invalid or does not match the expected issuer."

**MissingClaim**

The authentication token is missing required claims. Regenerate your token with proper scopes and claims.

"The authentication token is missing required claims."

**MissingKeyId**

The authentication token is missing the required key identifier in the JWT header. Ensure your token generation includes the kid field.

"The authentication token is missing the required key identifier."

**UnsupportedClient**

The client identifier is not supported. Verify your client credentials are registered for Creators API.

"The client identifier is not supported."

**InvalidClient**

The client identifier does not match the expected value. Verify you are using the correct client ID for your application.

"The client identifier does not match the expected value."

**MissingCredential**

Required authentication credentials are missing from the request. Include the Authorization header with a valid Bearer token and credential version header.

"Missing authentication credentials."

**Other**

Authentication check failed for a reason not covered by specific codes

Varies based on the specific authentication failure

### ThrottleException Details

When receiving a `ThrottleException`, the error response may include a `retryAfterSeconds` field indicating how long to wait before retrying:

Copy

```
{
  "type": "ThrottleException",
  "message": "The request was denied due to request throttling. Please verify the number of requests made per second.",
  "retryAfterSeconds": 60
}
```

### ResourceNotFoundException Details

When receiving a `ResourceNotFoundException`, the error response includes `resourceType` and `resourceId` fields:

-   **resourceType**: The type of resource that was not found
-   **resourceId**: The identifier of the resource that was not found

## Sample Error Scenarios

### Invalid PartnerTag

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Partner tag in the request is invalid or is not mapped to the store associated with your credential.",
  "reason": "InvalidPartnerTag"
}
```

### Invalid Associate

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Your credential is not linked to the partner tag in the request for the given Marketplace.",
  "reason": "InvalidAssociate"
}
```

### Missing or Invalid Field

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Request validation failed.",
  "reason": "FieldValidationFailed",
  "fieldList": ["partnerTag"]
}
```

### Expired Token

Copy

```
HTTP/1.1 401 Unauthorized
{
  "type": "UnauthorizedException",
  "message": "Authentication token has expired.",
  "reason": "TokenExpired"
}
```

### Invalid Token

Copy

```
HTTP/1.1 401 Unauthorized
{
  "type": "UnauthorizedException",
  "message": "The authentication token is invalid or malformed.",
  "reason": "InvalidToken"
}
```

### Ineligible Associate

Copy

```
HTTP/1.1 403 Forbidden
{
  "type": "AccessDeniedException",
  "message": "Your account does not currently meet the eligibility requirements.",
  "reason": "AssociateNotEligible"
}
```

### Rate Limiting

This error occurs when you exceed the allowed number of requests per second. When you receive a 429 status code, you should implement exponential backoff and retry the request after waiting.

Copy

```
HTTP/1.1 429 Too Many Requests
{
  "type": "ThrottleException",
  "message": "The request was denied due to request throttling. Please verify the number of requests made per second."
}
```

### Item Not Accessible

Copy

```
HTTP/1.1 404 Not Found
{
  "type": "ResourceNotFoundException",
  "message": "No items found for the requested item IDs.",
  "resourceType": "Item",
  "resourceId": "B08N5WRWNW"
}
```

### InternalServerException

Copy

```
HTTP/1.1 500 Internal Server Error
{
  "type": "InternalServerException",
  "message": "An unexpected error occurred while processing your request."
}
```

* * *

## Best Practices

-   Check HTTP status codes and parse the `reason` field for specific error handling
-   Implement exponential backoff retry for 429 and 500 errors
-   Implement token refresh logic for TokenExpired errors

For more information, see [Processing of Errors](./_creatorsapi_docs_en-us_troubleshooting_processing-of-errors.md) and [Troubleshooting Applications](./_creatorsapi_docs_en-us_troubleshooting_troubleshooting-applications.md).
