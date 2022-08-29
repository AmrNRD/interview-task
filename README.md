<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This project

This project was generated successfully using HydrogenSAAS

#### Documentation
To open swagger documentation open 
`/api/documentation`

###Task 
Create a Laravel API E-Commerce project to achieve these requirements:
1. Merchants can create their store.
2. Merchants can decide if the VAT is included in the product's price or should be
calculated from the product's price.
3. Merchants can set shipping cost.
4. Merchants can set VAT percentage or value in case the VAT isn’t included in the
product’s price.
5. Merchants can add products with Arabic/English names and description with the
same prices.
6. User can add products to their cart.
7. Calculate the cart’s total considering these subtotals:
- Cart’s product prices.
- Store VAT settings.
- Store shipping cost.


#####Steps to list the cart

    -  Signup new user
    -  Create new store 
        - if vat_percentage is null then the there will not be vat added to the products.
        - if shipping_cost is null then the there will not be shipping cost will be free.
        - by default user_id is Authed user id.
    -  Create new product 
        - if vat_included is set to true the store VAT will not be added.
    -  Create new cart 
        - by default user_id is Authed user id.
    -  Create new cart item
        - by default quantity is 1.        
