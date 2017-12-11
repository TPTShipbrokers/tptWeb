<?php

return [
    "menu_items" => [
        "Users" => ["View All" => "users/", "Create New" => "users/create"],
        "Chartering" => ["View All" => "chartering/", "Create New" => "chartering/create"],
        "WAF Positions" => ["View All" => "waf-positions/", "Create New" => "waf-positions/create"],
        "UKC Positions" => ["View All" => "ara-positions/", "Create New" => "ara-positions/create"],
        //"Invoices" => ["View All" => "invoices/", "Create New" => "invoices/create"],
        "Companies" => ["View All" => "companies/"],
        "Statuses" => ["View All" => "statuses/"],
        "Market Reports" => ["View All" => "market_reports/", "Create New" => "market_reports/create"],
    ],
    "dashboard_items" => [
        "Users" => "users/",
        //"Invoices" => "invoices/",
        "Chartering" => "chartering/",
        "WAF Positions" => "waf-positions/",
        "UKC Positions" => "ara-positions/",
        "Statuses" => "statuses/",
        "Companies" => "companies/",
        "Market Reports" => "market_reports/",
    ],
    "menu_icons" => [
        "Users" => "icon-user",
        //"Invoices" => "fa fa-bar-chart-o",
        "Chartering" => "fa fa-ship",
        "WAF Positions" => "fa fa-map-marker",
        "UKC Positions" => "fa fa-map-marker",
        "Statuses" => "fa fa-flag",
        "Companies" => "fa fa-building-o",
        "Market Reports" => "fa fa-file-o",
    ],
    "role_colors" => [
        "admin" => "btn red-sunglo btn-circle btn-sm",
        "client" => "btn blue btn-circle btn-sm",
        "team" => "btn green btn-circle btn-sm"
    ],
    "status_colors" => [
        "active" => "label label-sm label-info",
        "blocked" => "label label-sm label-danger",
        "inactive" => "label label-sm label-default"
    ],
];
