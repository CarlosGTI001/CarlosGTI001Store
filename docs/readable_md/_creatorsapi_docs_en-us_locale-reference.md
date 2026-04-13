# Locale Reference for Product Advertising API

Source: `_creatorsapi_docs_en-us_locale-reference.html`

# Locale Reference for Product Advertising API

Product Advertising API operations are the same for all locales but valid certain parameters vary by locale. For example, `SearchIndex` values used in `SearchItems` API varies by locale.

The Product Advertising API is available in the following locales:

Locale

URL

Australia

[https://www.amazon.com.au](https://www.amazon.com.au/)

Belgium

[https://www.amazon.com.be](https://www.amazon.com.be/)

Brazil

[https://www.amazon.com.br](https://www.amazon.com.br/)

Canada

[https://www.amazon.ca](https://www.amazon.ca/)

Egypt

[https://www.amazon.eg](https://www.amazon.eg/)

France

[https://www.amazon.fr](https://www.amazon.fr/)

Germany

[https://www.amazon.de](https://www.amazon.de/)

India

[https://www.amazon.in](https://www.amazon.in)

Ireland

[https://www.amazon.ie](https://www.amazon.ie/)

Italy

[https://www.amazon.it](https://www.amazon.it/)

Japan

[https://www.amazon.co.jp](https://www.amazon.co.jp)

Mexico

[https://www.amazon.com.mx](https://www.amazon.com.mx/)

Netherlands

[https://www.amazon.nl](https://www.amazon.nl/)

Poland

[https://www.amazon.pl](https://www.amazon.pl/)

Singapore

[https://www.amazon.sg](https://www.amazon.sg/)

Saudi Arabia

[https://www.amazon.sa](https://www.amazon.sa/)

Spain

[https://www.amazon.es](https://www.amazon.es/)

Sweden

[https://www.amazon.se](https://www.amazon.se/)

Turkey

[https://www.amazon.com.tr](https://www.amazon.com.tr/)

United Arab Emirates

[https://www.amazon.ae](https://www.amazon.ae/)

United Kingdom

[https://www.amazon.co.uk](https://www.amazon.co.uk/)

United States

[https://www.amazon.com](https://www.amazon.com/)

Each of these locales is serviced by an Amazon web site that uses the local language, local customs, and local formatting. For example, when you look at the DE homepage for Amazon, you see the listings in German. If you purchased an item, you would find the price in Euros, and, if you were to purchase a movie, you would find that the movie rating would conform to the movie rating system used in Germany. Product Advertising API responses contain the same localized information.

Following topics cover locale specific reference for the following parameters:

-   **Marketplace**: Target Amazon Locale. The endpoint supplied to the marketplace parameter determines which locale the API request is targeted to.
-   **Language of Preference**: Most of Product Advertising API response elements are language aware. Every locale has a default language which the API falls back to if the supplied language of preference is invalid or if no language of preference is provided.
-   **Valid Languages**: Allowed Languages in a marketplace. Every marketplace supports only certain languages and information can be returned in only those languages for the marketplace.
-   **Currency of Preference**: Some of Product Advertising API response elements are currency aware such as Item price. API uses the default currency of the locale if currency of preference is not provided. Else when currency of preference is provided, it's value should be a valid currency of the locale, and API falls back to the default currency if conversion is unsuccessful.
-   **Valid Currencies**: Allowed Currencies in a marketplace. Every marketplace supports only certain currencies and information can be returned in only those currencies for the marketplace.
-   **Search Index**: The SearchItems operation requires SearchIndex which indicates the product category to search. SearchIndexes differ by marketplace and each marketplace has it's own list of valid SearchIndices.

## Topics

-   [Locale Reference for Australia](./_creatorsapi_docs_en-us_locale-reference_australia.md)
-   [Locale Reference for Belgium](./_creatorsapi_docs_en-us_locale-reference_belgium.md)
-   [Locale Reference for Brazil](./_creatorsapi_docs_en-us_locale-reference_brazil.md)
-   [Locale Reference for Canada](./_creatorsapi_docs_en-us_locale-reference_canada.md)
-   [Locale Reference for Egypt](./_creatorsapi_docs_en-us_locale-reference_egypt.md)
-   [Locale Reference for France](./_creatorsapi_docs_en-us_locale-reference_france.md)
-   [Locale Reference for Germany](./_creatorsapi_docs_en-us_locale-reference_germany.md)
-   [Locale Reference for India](./_creatorsapi_docs_en-us_locale-reference_india.md)
-   [Locale Reference for Ireland](./_creatorsapi_docs_en-us_locale-reference_ireland.md)
-   [Locale Reference for Italy](./_creatorsapi_docs_en-us_locale-reference_italy.md)
-   [Locale Reference for Japan](./_creatorsapi_docs_en-us_locale-reference_japan.md)
-   [Locale Reference for Mexico](./_creatorsapi_docs_en-us_locale-reference_mexico.md)
-   [Locale Reference for Netherlands](./_creatorsapi_docs_en-us_locale-reference_netherlands.md)
-   [Locale Reference for Poland](./_creatorsapi_docs_en-us_locale-reference_poland.md)
-   [Locale Reference for Singapore](./_creatorsapi_docs_en-us_locale-reference_singapore.md)
-   [Locale Reference for Saudi Arabia](./_creatorsapi_docs_en-us_locale-reference_saudi-arabia.md)
-   [Locale Reference for Spain](./_creatorsapi_docs_en-us_locale-reference_spain.md)
-   [Locale Reference for Sweden](./_creatorsapi_docs_en-us_locale-reference_sweden.md)
-   [Locale Reference for Turkey](./_creatorsapi_docs_en-us_locale-reference_turkey.md)
-   [Locale Reference for United Arab Emirates](./_creatorsapi_docs_en-us_locale-reference_united-arab-emirates.md)
-   [Locale Reference for United Kingdom](./_creatorsapi_docs_en-us_locale-reference_united-kingdom.md)
-   [Locale Reference for United States](./_creatorsapi_docs_en-us_locale-reference_united-states.md)
