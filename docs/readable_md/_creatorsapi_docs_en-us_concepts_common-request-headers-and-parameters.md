# Common Request Headers and Parameters

Source: `_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.html`

# Common Request Headers and Parameters

This document describes the request headers and parameters that are common to all Creators API operations.

## Headers

The following table describes the HTTP headers that must be included in all Creators API requests:

Header

Definition

Required

Example Value

Content-Type

The content type of the request body. Must be set to `application/json`.

Yes

`application/json`

Authorization (using v2.x credentials)

Bearer token for authenticating API requests with v2.x credentials. The value should be in the format: `Bearer <access_token>, Version <credential_version>` where credential\_version is `2.1` for NA, `2.2` for EU, `2.3` for FE.

Yes

`Bearer eyJraWQiOiJ..., Version 2.1`

Authorization (using v3.x credentials)

Bearer token for authenticating API requests with v3.x credentials. Simply use: `Bearer <access_token>`. No version header required.

Yes

`Bearer Atc|MQICIJvS...`

x-marketplace

Target Amazon marketplace passed as an HTTP header. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

## Parameters

The following table describes the request parameters that are common to all Creators API operations:

Parameter

Definition

Required

Example Value

marketplace

Target Amazon marketplace. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

partnerTag

An alphanumeric token that uniquely identifies a partner. In case of an associate, this token is the means by which Amazon identifies the Associate to credit for a sale. Specify the `store ID` or `tracking ID` of a valid associate store from the requested marketplace as the value for `partnerTag`. For example, If `store-20` and `store-21` are store id or tracking id of customer in United States and United Kingdom marketplaces respectively, then customer needs to pass `store-20` as `partnerTag` in all Creators API requests for United States marketplace and `store-21` as `partnerTag` in all Creators API requests for United Kingdom marketplace. To obtain a Partner Tag, see [Sign up as an Amazon Associate](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate.md).

Yes

`store-20`

## Marketplace/Locale Reference

Locale

Marketplace

Region

Australia

`www.amazon.com.au`

FE

Belgium

`www.amazon.com.be`

EU

Brazil

`www.amazon.com.br`

NA

Canada

`www.amazon.ca`

NA

Egypt

`www.amazon.eg`

EU

France

`www.amazon.fr`

EU

Germany

`www.amazon.de`

EU

India

`www.amazon.in`

EU

Ireland

`www.amazon.ie`

EU

Italy

`www.amazon.it`

EU

Japan

`www.amazon.co.jp`

FE

Mexico

`www.amazon.com.mx`

NA

Netherlands

`www.amazon.nl`

EU

Poland

`www.amazon.pl`

EU

Singapore

`www.amazon.sg`

FE

Saudi Arabia

`www.amazon.sa`

EU

Spain

`www.amazon.es`

EU

Sweden

`www.amazon.se`

EU

Turkey

`www.amazon.com.tr`

EU

United Arab Emirates

`www.amazon.ae`

EU

United Kingdom

`www.amazon.co.uk`

EU

United States

`www.amazon.com`

NA
