# API Reference

Source: `_creatorsapi_docs_en-us_api-reference.html`

# API Reference

The following sections of the guide provide API reference material for the Creators API. For more information about Creators API overview and basic concepts, refer to the previous chapters in this guide. For registering with Creators API, refer [Register for Creators API](./_creatorsapi_docs_en-us_onboarding_register-for-creators-api.md) and for information on how to best use the API for some common use cases, refer our [Using SDK](./_creatorsapi_docs_en-us_get-started.md).

The following section contains information about Creators API operations, resources, locale specific information, etc in detail with examples for you to do it yourself.

## Operations

Creators API supports the following operations:

Operation Name

Description

[GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md)

Lookup information for a Browse Node

[GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)

Provides item attributes, offer listings, images, and other details for a given item

[SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

Searches for items on Amazon based on keywords

[GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

Returns variations for an item i.e. a set of items that are the same product, but differ according to a consistent theme, for example size and color

## Resources

Resources determine what information will be returned in the API response. Each operation can request only certain resources. For details on what all resources are valid for a particular Creators API operation, see [Operations](./_creatorsapi_docs_en-us_api-reference_operations.md).

Creators API supports following the high level resources:

High Level Resource

Description

[BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)

Returns browse node information associated with an item

[BrowseNodes](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

Returns browse node information associated with a Browse Node for a [GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md) request

[Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

Returns image URLs for an item in various sizes

[ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

Returns item information (Title, Brand, Description, etc.) for an item

[ParentASIN](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

Returns the parent ASIN for an item.

[SearchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

Returns dynamic search refinements for a search request

[VariationSummary](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

Returns summary for the [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operations

## Locale Reference

Creators API supports multiple Amazon marketplaces across the world. Each marketplace has specific configuration requirements including marketplace endpoint and region. See the [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md) section for details on all supported locales.
