
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width" />
        <title>Document</title>
        <style>
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            body {
                background: rgb(204, 204, 204);
                margin-top: 0;
                margin-left: 0;
            }
            @page {
                size: A4;
                margin: 0;
            }

            @media print {
                page {
                    width: 794px;
                    height: 1123px;
                }

                body {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
            }
        </style>
    </head>
    <?php include('/home/esez/domains/dev.esez.pl/public_html/wp-content/plugins/ewidencja-zmarlych/public/documents/templates/warszawa/template-zgloszenie-pogrzebu.php'); ?>
    <body>
        <page size="A4"></page>
    </body>

    </html>