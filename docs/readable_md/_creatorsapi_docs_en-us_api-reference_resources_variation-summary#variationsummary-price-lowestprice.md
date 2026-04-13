# VariationSummary

Source: `_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.html`

# VariationSummary

The `VariationSummary` resource provides the lowest price, highest price and variation dimensions for all variations in a response. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions. The resource is relevant for only [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operation.

## Availability

All locales.

## Response Elements

Name

Description

PageCount

The number of pages containing variation items with certain number of variations per page.

Price

Container for showing the lowest and highest price of the child ASINs.

VariationCount

The total number of child ASINs.

VariationDimensions

List of all the dimensions i.e consistent theme over which the items varies and their values.

### Price Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "pageCount": "The number of pages containing variations",
    "price": {
      "highestPrice": "Highest Price among the child ASINs",
      "lowestPrice": "Lowest Price among the child ASINs"
    },
    "variationCount": "The total number of child ASINs",
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

Refer following table for more information on each of the individual response elements of the Price response element:

ResponseElement

Description

HighestPrice

Highest Price among the child ASINs.

LowestPrice

Lowest Price among the child ASINs.

### VariationDimensions Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

ResponseElement

Description

DisplayName

Display Name of the Dimension as visible on the Amazon retail website.

Locale

The locale in which Display Name is returned.

Name

Name of the Dimension.

Values

List of all possible values for the Dimension.

## Relevant Operations

Operations that can use these resources include:

-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

[variationSummary.price.highestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.md)

Get the highest price among the child ASINs.

[variationSummary.price.lowestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.md)

Get the lowest price among the child ASINs.

[variationSummary.variationDimension](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.md)

Get the details about the dimensions like name, display-name and possible values on which the item varies.

### VariationSummary Price HighestPrice

Requesting this resource returns the highest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Price LowestPrice

Requesting this resource returns the lowest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 2,
      "price": {
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Variation Dimension

Requesting this resource returns the details about the dimensions like name, display-name and possible values.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 2,
      "variationCount": 13,
      "variationDimensions": [
        {
          "displayName": "Size",
          "name": "size_name",
          "values": [
            "One Size"
          ]
        },
        {
          "displayName": "Colour",
          "name": "color_name",
          "values": [
            "Brown",
            "Navy",
            "Black",
            "Burgundy",
            "Cognac",
            "Gray",
            "Green",
            "Logan - Tan",
            "Navy/Black",
            "Red",
            "Rfid-black",
            "Rfid-navy",
            "Tan"
          ]
        }
      ]
    }
  }
}
```
