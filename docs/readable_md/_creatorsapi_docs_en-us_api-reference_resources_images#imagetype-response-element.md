# Images

Source: `_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.html`

# Images

The Images resources returns the URLs for all available images of an item in three sizes: `Small`, `Medium`, and `Large`. For example, if a Kindle has four images, the images resources returns the URLs of 12 images: four images, each in three sizes.

In addition to returning the image URLs, these resources also return the height and width dimensions of each image. Use these values to display the images correctly.

## Availability

All locales.

## Response Elements

Name

Description

Primary

Container for Primary Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

Variants

Container for Variants Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

#### ImageType Response Element

The structure of ImageType (Primary / Variants) container inside the high level Images Resource is as follows:

Copy

```
{
  "imageType": {
    "imageSize": {
      "url": "Image URL",
      "height": "Number representing width of the image",
      "width": "Number representing height of the image"
    }
  }
}
```

-   Each of the `ImageType` (Primary / Variant) can contain three sub-resources: Small, Medium, and Large.
-   Each of the `ImageSize` (Small / Medium / Large) contains three values: URL, Height, and Width of the image.

> The `Primary` image denotes the image which is displayed in search results and on the detail page. **Variants** include everything else. The sizes of the images are specified by the `_SLXXX_` suffix in the URL, where `XXX` is the number of pixels on the longest side of the image. For example, a medium size image has 160 pixels on its longest side, so it has the suffix `_SL160_`. This is the preferred way to reference images.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

images.primary.small

Get the primary image of an item in small size.

images.primary.medium

Get the primary image of an item in medium size.

images.primary.large

Get the primary image of an item in large size.

images.variants.small

Get the variant images of an item in small size.

images.variants.medium

Get the variant images of an item in medium size.

images.variants.large

Get the variant images of an item in large size.

## Sample Use Cases

### Example 1

Get the primary image of an item, in large size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  }
 }
}
```

### Example 2

Get the primary image of an item in large size, and variant images in small size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large", "images.variants.small"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   }
  }, ...]
 }
}
```

### Example 3

Get all images of an item, in all sizes.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.small", "images.primary.medium", "images.primary.large", "images.variants.small", "images.variants.medium", "images.variants.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "small": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL.jpg",
    "height": 500,
    "width": 500
   }
  }, ...]
 }
}
```
