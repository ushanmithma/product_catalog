<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Draft = 'Draft';
    case Published = 'Published';
    case OutofStock = 'Out of Stock';
}
