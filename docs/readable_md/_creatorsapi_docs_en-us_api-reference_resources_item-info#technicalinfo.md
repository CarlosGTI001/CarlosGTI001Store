# ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```
