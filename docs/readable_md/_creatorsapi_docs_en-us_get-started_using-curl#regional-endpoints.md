# Using cURL

Source: `_creatorsapi_docs_en-us_get-started_using-curl#regional-endpoints.html`

# Using cURL

Once you have signed up for Amazon Associates program and Creators API, you can start sending requests to the API. You can send requests to Creators API using SDKs (recommended) or directly using HTTP requests. This guide shows you how to make API calls using cURL.

## Request Components

Requests to Creators API have the following main components:

1.  **Headers** - Authentication and metadata about the request
2.  **Request Payload** - JSON formatted Request Body

The following sections explain how to obtain the authentication token for headers, how to construct the request payload, and finally how to put everything together in a complete cURL command.

## Step 1: Fetch Access Token (for Headers)

To authenticate your requests, you need to obtain an OAuth 2.0 access token from the Cognito token endpoint. This token will be used in the Authorization header for all API calls.

## Regional Endpoints

The Creators API uses different authentication endpoints based on your credential version:

**Region**

**Version**

**Token Endpoint**

**Marketplaces**

NA (North America)

2.1

`creatorsapi.auth.us-east-1.amazoncognito.com/oauth2/token`

US, CA, MX, BR

EU (Europe)

2.2

`creatorsapi.auth.eu-south-2.amazoncognito.com/oauth2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

2.3

`creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token`

JP, SG, AU

NA (North America)

3.1

`api.amazon.com/auth/o2/token`

US, CA, MX, BR

EU (Europe)

3.2

`api.amazon.co.uk/auth/o2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

3.3

`api.amazon.co.jp/auth/o2/token`

JP, SG, AU

The API endpoint for all regions is: `https://creatorsapi.amazon`

For a complete list of marketplace-specific parameters, see [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md).

## Token Generation for v2.x Credentials

### Method 1: Credentials in Request Body

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`

**Request Body:**

Copy

```
grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -v -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default"
```

### Method 2: Credentials in Authorization Header

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`
-   `Authorization: Basic <Base64-encoded credentials>`

**Authorization Header:** Encode your `client_id:client_secret` in Base64 format. For example, if your client\_id is `abc123` and client\_secret is `xyz789`, you would encode `abc123:xyz789`.

**Request Body:**

Copy

```
grant_type=client_credentials&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
 -H "Content-Type: application/x-www-form-urlencoded" \
 -H "Authorization: Basic $(echo -n 'YOUR_CLIENT_ID:YOUR_CLIENT_SECRET' | base64)" \
 -d "grant_type=client_credentials&scope=creatorsapi/default"
```

**Response:**

Copy

```
{
  "access_token": "eyJraWQiOiJ...",
  "expires_in": 3600,
  "token_type": "Bearer"
}
```

**Note:** Access tokens typically expire after 3600 seconds (1 hour). Store the token securely and refresh it before expiration. **New access token is not needed for every request and should be cached until they expire.**

## Token Generation for v3.x Credentials (LwA)

For v3.x credentials, use the Login with Amazon (LwA) token endpoint with a JSON request body. Use the appropriate regional endpoint from the table above.

**Headers:**

-   `Content-Type: application/json`

**Request Body:**

Copy

```
{
  "grant_type": "client_credentials",
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "scope": "creatorsapi::default"
}
```

**Example cURL Command:**

Copy

```
curl -X POST https://api.amazon.com/auth/o2/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "client_credentials",
    "client_id": "YOUR_CLIENT_ID",
    "client_secret": "YOUR_CLIENT_SECRET",
    "scope": "creatorsapi::default"
  }'
```

**Response:**

Copy

```
{
  "access_token": "Atc|MQICIJvSKVTZ...",
  "scope": "creatorsapi::default",
  "token_type": "bearer",
  "expires_in": 3600
}
```

## Step 2: Make API Calls to CreatorsAPI

Once you have the access token, include it in the `Authorization` header for all API requests.

> Examples in this section use the US locale for headers and request parameters. These common parameters are listed in [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md), and locale-specific values (such as marketplace) can be adjusted for your target Amazon locale.

**Base URL:** `https://creatorsapi.amazon`

**Headers:**

-   `Authorization: Bearer <access_token>, Version <credential_version>` (for v2.x credentials)
-   `Authorization: Bearer <access_token>` (for v3.x credentials)
-   `Content-Type: application/json`
-   `x-marketplace: <marketplace_domain>`

### Example: GetItems API Call

Copy

```
curl -X POST https://creatorsapi.amazon/catalog/v1/getItems \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -H "x-marketplace: www.amazon.com" \
  -d '{
    "itemIds": ["B09B2SBHQK", "B09B8V1LZ3"],
    "itemIdType": "ASIN",
    "marketplace": "www.amazon.com",
    "partnerTag": "xyz-20",
    "resources": [
      "images.primary.small",
      "itemInfo.title",
      "itemInfo.features",
      "parentASIN"
    ]
  }'
```

**Response:**

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B09B2SBHQK",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B2SBHQK?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 49,
              "url": "https://m.media-amazon.com/images/I/41cNJGm9ZFL._SL75_.jpg",
              "width": 75
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Alexa can show you more - Echo Show 5 includes a 5.5” display so you can see news and weather at a glance, make video calls, view compatible cameras, stream music and shows, and more.",
              "Small size, bigger sound – Stream your favorite music, shows, podcasts, and more from providers like Amazon Music, Spotify, and Prime Video—now with deeper bass and clearer vocals. Includes a 5.5\" display so you can view shows, song titles, and more at a glance.",
              "Keep your home comfortable – Control compatible smart devices like lights and thermostats, even while you're away.",
              "See more with the built-in camera – Check in on your family, pets, and more using the built-in camera. Drop in on your home when you're out or view the front door from your Echo Show 5 with compatible video doorbells.",
              "See your photos on display – When not in use, set the background to a rotating slideshow of your favorite photos. Invite family and friends to share photos to your Echo Show. Prime members also get unlimited cloud photo storage.",
              "Stay connected with video calling – Use the 2 MP camera to call friends and family who have the Alexa app or an Echo device with a screen. Make announcements to other compatible devices in your home.",
              "Designed to protect your privacy— Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls including a mic/camera off button and built-in camera shutter, as well as support for viewing end-to-end encrypted Ring video.",
              "Designed for sustainability – This device’s fabric is made from 100% post-consumer recycled polyester yarn and aluminum is made from 100% recycled aluminum. The device packaging is 100% recyclable."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Show 5 (newest model), Smart display with Alexa+ Early Access, 2x the bass and clearer sound, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BZTW3TCH",
        "score": null,
        "variationAttributes": null
      },
      {
        "asin": "B09B8V1LZ3",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B8V1LZ3?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/315PBUzfZiL._SL75_.jpg",
              "width": 46
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Your favorite music and content – Play music, audiobooks, and podcasts from Amazon Music, Apple Music, Spotify and others or via Bluetooth throughout your home.",
              "Alexa is happy to help – Ask Alexa for weather updates and to set hands-free timers, get answers to your questions and even hear jokes. Need a few extra minutes in the morning? Just tap your Echo Dot to snooze your alarm.",
              "Keep your home comfortable – Control compatible smart home devices with your voice and routines triggered by built-in motion or indoor temperature sensors. Create routines to automatically turn on lights when you walk into a room, or start a fan if the inside temperature goes above your comfort zone.",
              "Designed to protect your privacy – Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls, including a mic off button.",
              "Do more with device pairing– Fill your home with music using compatible Echo devices in different rooms, create a home theatre system with Fire TV, or extend wifi coverage with a compatible eero network so you can say goodbye to drop-offs and buffering."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Dot (newest model) - Vibrant sounding speaker with Alexa+ Early Access, Great for bedrooms, dining rooms and offices, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BF73CTQF",
        "score": null,
        "variationAttributes": null
      }
    ]
  }
}
```

## Best Practices

-   **Token Management:** Cache access tokens and reuse them until they expire to minimize authentication requests (This is handled automatically when you are using the SDK)
-   **Error Handling:** Implement retry logic with exponential backoff for transient failures
-   **Security:** Never expose your client\_id and client\_secret in client-side code or public repositories
-   **Rate Limiting:** Respect API rate limits and implement appropriate throttling in your application
