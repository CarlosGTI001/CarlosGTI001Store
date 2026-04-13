# Migrating to Creators API from Product Advertising API

Source: `_creatorsapi_docs_en-us_migrating-to-creatorsapi-from-paapi.html`

# Migrating to Creators API from Product Advertising API

If you are an existing Product Advertising API (PA-API 5.0) customer, you need to migrate to the new Creators API. The Creators API provides the same functionality as PA-API 5.0 with enhanced authentication using OAuth 2.0 and improved credential management.

## Key Differences

The main differences between Product Advertising API and Creators API are:

**Aspect**

**Product Advertising API 5.0**

**Creators API**

**Authentication**

AWS Signature Version 4 (Access Key + Secret Key)

OAuth 2.0 (Credential ID + Credential Secret)

**Endpoints**

`webservices.amazon.com/paapi5/...`

`creatorsapi.amazon/catalog/v1/...`

**Token Management**

AWS signature required for each request

Bearer token (valid for 1 hour, cacheable)

**Request/Response Parameters**

PascalCase (e.g., `ItemIds`, `PartnerTag`)

lowerCamelCase (e.g., `itemIds`, `partnerTag`)

**Offers Support**

Available (Offers.Listings, Offers.Summaries)

Not Available. use [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md#offersv1-to-offersv2-field-mapping.md)

The primary difference is the shift from AWS Signature Version 4 authentication to OAuth 2.0, which simplifies the authentication process and enables token caching. All request and response parameters have been converted from PascalCase to lowerCamelCase.

> Your existing Product Advertising API credentials (AWS Access Key and Secret Key) will not work with the Creators API. You must register for Creators API and generate new credentials.

## Migration Steps

### Step 1: Register for Creators API

Complete the registration process to obtain your new credentials:

1.  Navigate to [Associates Central](http://affiliate-program.amazon.com/creatorsapi) or look for "CreatorsAPI" tab under the Tools hamburger menu
2.  Click **Create Application** - Enter a name for your application
3.  Click **Create Credential** - Copy and securely store the following values:
    -   **Credential ID** (replaces AWS Access Key)
    -   **Credential Secret** (replaces AWS Secret Key)
    -   **Version** (credential version based on your region: 2.1 for NA, 2.2 for EU, 2.3 for FE)

For complete registration instructions, see [Register for Creators API](./_creatorsapi_docs_en-us_onboarding_register-for-creators-api.md).

> Store your Credential Secret securely. It will only be displayed once during creation. If lost, you'll need to generate a new credential.

### Step 2: Choose Your Migration Path

You have two options to migrate your existing Product Advertising API applications:

#### Option A: Use the New SDKs (Recommended)

The Creators API provides SDKs for Node.js, Python, PHP, and Java that automatically handle OAuth 2.0 authentication and token management.

**Benefits:**

-   Automatic token caching and renewal
-   Simplified authentication flow
-   Built-in error handling
-   Same familiar SDK structure as PA-API 5.0

To get started with SDKs:

1.  Download the SDK for your language from [Using SDK](./_creatorsapi_docs_en-us_get-started.md)
2.  Replace your AWS credentials with the new Credential ID, Credential Secret, and Version
3.  Update API operation names if needed (endpoints remain similar)

**Example Migration (Python):**

**Before (PA-API 5.0):**

Copy

```
from paapi5_python_sdk.api.default_api import DefaultApi
from paapi5_python_sdk.models.search_items_request import SearchItemsRequest

access_key = "YOUR_ACCESS_KEY"
secret_key = "YOUR_SECRET_KEY"
partner_tag = "yourtag-20"

api_instance = DefaultApi(
    access_key=access_key,
    secret_key=secret_key,
    host="webservices.amazon.com",
    region="us-east-1"
)
```

**After (Creators API):**

Copy

```
from creators_api.api.default_api import DefaultApi
from creators_api.models.search_items_request import SearchItemsRequest

credential_id = "YOUR_CREDENTIAL_ID"
credential_secret = "YOUR_CREDENTIAL_SECRET"
version = "2.3"  # Based on your region
partner_tag = "yourtag-20"

api_instance = DefaultApi(
    credential_id=credential_id,
    credential_secret=credential_secret,
    version=version,
    marketplace="www.amazon.com"
)
```

For detailed SDK setup, see [Using SDK](./_creatorsapi_docs_en-us_get-started.md).

#### Option B: Update Your Direct API Calls

If you're making direct HTTP requests (using cURL, axios, requests, etc.) instead of using SDKs, you'll need to:

1.  **Update Authentication Flow:**
    
    -   Remove AWS Signature Version 4 signing logic
    -   Implement OAuth 2.0 token retrieval
    -   Add token caching and renewal logic
2.  **Update API Endpoints:**
    
    -   Change from `https://webservices.amazon.com/paapi5/*` to `https://creatorsapi.amazon/catalog/v1/*`
3.  **Update Request Headers:**
    
    -   Replace AWS signature headers with OAuth 2.0 Bearer token
    -   Add credential version to Authorization header
    -   Add marketplace header (x-marketplace)

**Example Migration (cURL):**

**Before (PA-API 5.0):**

Copy

```
curl -X POST https://webservices.amazon.com/paapi5/searchitems \
  -H "Content-Type: application/json" \
  -H "X-Amz-Date: 20231215T120000Z" \
  -H "Authorization: AWS4-HMAC-SHA256 Credential=..." \
  -d '{
    "Keywords": "headphones",
    "PartnerTag": "yourtag-20",
    "PartnerType": "Associates",
    "Marketplace": "www.amazon.com",
    "Resources": ["Images.Primary.Small", "ItemInfo.Title"]
  }'
```

**After (Creators API):**

First, obtain an access token:

Copy

```
curl -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "Authorization: Basic $(echo -n 'YOUR_CREDENTIAL_ID:YOUR_CREDENTIAL_SECRET' | base64)" \
  -d "grant_type=client_credentials&scope=creatorsapi/default"
```

Then make API calls with the token:

Copy

```
curl -X POST https://creatorsapi.amazon/catalog/v1/searchItems \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN, Version YOUR_CREDENTIAL_VERSION" \
  -H "Content-Type: application/json" \
  -H "x-marketplace: www.amazon.com" \
  -d '{
    "keywords": "headphones",
    "partnerTag": "yourtag-20",
    "marketplace": "www.amazon.com",
    "resources": ["images.primary.small", "itemInfo.title"]
  }'
```

For complete cURL examples and authentication details, see [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md).

### Step 3: Update Request Parameters

While most request parameters remain similar, note the following changes:

**PA-API 5.0 Parameter**

**Creators API Parameter**

**Notes**

`Keywords`

`keywords`

Changed to camelCase

`ItemIds`

`itemIds`

Changed to camelCase

`PartnerTag`

`partnerTag`

Changed to camelCase

`Resources`

`resources`

Resource names use dot notation (same as PA-API 5.0)

`Marketplace`

`marketplace`

Changed to camelCase, also required in x-marketplace header

### Step 4: Test Your Migration

1.  Start with a simple GetItems or SearchItems request
2.  Verify authentication and token management works correctly
3.  Test all API operations your application uses
4.  Implement proper error handling for new error codes
5.  Monitor API rate limits and adjust throttling if needed

> Access tokens are valid for 3600 seconds (1 hour). Implement token caching and renewal logic to avoid unnecessary authentication requests. SDKs handle this automatically. For regional endpoint details including authentication token endpoints by version, see the [Regional Endpoints section in Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl#regional-endpoints.md).

## Common Migration Issues

**Issue**

**Problem**

**Solution**

**Invalid Credentials**

Using AWS Access Key/Secret Key instead of Credential ID/Secret

Generate new credentials from Associates Central CreatorsAPI dashboard

**Token Expired**

Access token expired after 1 hour

Implement token caching and renewal. Check token expiry before each request and refresh if needed

**Wrong Endpoint**

Still using `webservices.amazon.com/paapi5/*` endpoints

Update to `creatorsapi.amazon/catalog/v1/*` endpoints

**Missing Marketplace Header**

Request fails with missing marketplace information

Add `x-marketplace` header (e.g., `x-marketplace: www.amazon.com`)

**Incorrect Authorization Header**

Authorization header doesn't include credential version

Use format: `Authorization: Bearer <token>, Version <version>`

> If you encounter errors during migration, check the [Error Codes and Messages](./_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.md) documentation for detailed troubleshooting steps.

## Additional Resources

-   [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) - Locale-specific configuration
-   [GetItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) - Retrieve product details
-   [SearchItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) - Search for products
-   [Error Codes and Messages](./_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.md) - Troubleshooting errors
-   [API Rates](./_creatorsapi_docs_en-us_concepts_api-rates.md) - Understanding rate limits

> For most developers, using the SDKs is the fastest migration path. The SDKs handle authentication, token management, and request formatting automatically, allowing you to focus on your application logic.
