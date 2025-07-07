<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>{{ $title ?? 'Notifikasi' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet" media="screen">
    <style>
        .hover-underline:hover {
            text-decoration: underline !important;
        }

        p {
            font-size: 12px;
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }

        thead,
        tbody,
        tfoot,
        tr,
        td,
        th {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
            font-size: 12px;
            font-weight: 500;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #6e6b7b;
            --bs-table-striped-bg: #fafafc;
            --bs-table-active-color: #6e6b7b;
            --bs-table-active-bg: rgba(34, 41, 47, 0.1);
            --bs-table-hover-color: #6e6b7b;
            --bs-table-hover-bg: #f6f6f9;
            width: 100%;
            margin-bottom: 1rem;
            color: #6e6b7b;
            vertical-align: middle;
            border-color: #ebe9f1;
        }

        .table > :not(caption) > * > * {
            padding: 0.72rem 2rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .table > tbody {
            vertical-align: inherit;
        }

        .table > thead {
            vertical-align: bottom;
        }

        .table > :not(:first-child) {
            border-top: 2px solid #ebe9f1;
        }

        .caption-top {
            caption-side: top;
        }

        .table-sm > :not(caption) > * > * {
            padding: 0.3rem 0.5rem;
        }

        @media (max-width: 600px) {
            .sm-w-full {
                width: 100% !important;
            }

            .sm-px-24 {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }

            .sm-py-32 {
                padding-top: 12px !important;
                padding-bottom: 12px !important;
            }

            .sm-leading-32 {
                line-height: 12px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #eceff1; font-family: 'Montserrat', sans-serif;">
    @yield('content')
</body>
</html>
