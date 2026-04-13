# ParentASIN

Source: `_creatorsapi_docs_en-us_api-reference_resources_parent-asin.html`

# ParentASIN

An item can come in a variety of sizes and colors. Each color and size combination is called a variation or child ASIN. The abstraction of the variations is called the parent ASIN. The child ASIN is the specific variation of the product (Levi’s 501 Jeans size large and color black). Because the parent ASIN is an abstraction, it can't be purchased and hence is not associated with an offer. For more information on variations and parent ASIN, refer [Variations Use Case](./_creatorsapi_docs_en-us_use-cases_organization-of-items-on-amazon_variations.md).

A product with variations can have several variations. The Amazon Product Landing Page for a parentASIN will have all variation attributes unselected and would lack the offer information. Customers have flexibility to select the variation attribute to land on the product landing page of the desired variation child ASIN.

The parentASIN resource returns the parent ASIN of an item.

## Availability

All locales.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example

Get the parent ASIN of an item.

#### Request Payload

Copy

```
{
"associateTag": "xyz-20",
"itemIds": ["B00TSUGXKE"],
"resources": ["parentASIN"]
}
```

#### Response

Copy

```
{
"asin": "B00TSUGXKE",
"parentASIN": "B010BWYDYA"
}
```
