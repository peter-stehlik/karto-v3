<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php
        $itemsPerPage = 12; // 2 columns

        if( $columns == 3 ){
            $itemsPerPage = 24;
        }
    ?>

    <style>
        @page { margin: 0; }
        body { 
            @if( $columns == 2 ) 
                margin-top: 50px; margin-top: 50px;
            @elseif( $columns == 3 )
                margin-top: 45px; margin-top: 45px;
            @endif
            margin-left: 20px; margin-right: 20px; font-family: 'DejaVu Sans', sans-serif; font-size:12px; line-height: 1; letter-spacing: 0.5px; /*color: #ccc; */
        }
        .page-break { page-break-after: always; }
        p { padding: 0; margin: 0; }
        table { width: 100%; padding: 0; margin: 0; }
        td { padding: 0; margin: 0; vertical-align: center; }
        .content {
            @if( $columns == 2 )
                width: 300px;
                height: 138px;
                padding: 30px 20px 0;
            @elseif( $columns == 3 ) 
                width: 210px;
                height: 118px;
                padding: 10px 10px 0 20px;
                font-size: 11px;
            @endif
            overflow: hidden;
        }
        .inner-table td {
            height: 10px;
        }
        .one-line {
            overflow: hidden;
            white-space: nowrap;
        }
        .short-line {
            @if( $columns == 2 )
                width: 150px;
            @elseif( $columns == 3 ) 
                width: 100px;
            @endif
            overflow: hidden;
        }
    </style>
</head>
<body>
<?php
    $people_count = count($people);
    $offset = 0;
    if( $start_position ){
        $offset = $start_position - 1; // let it be zero based
    }
    $total = $people_count + $offset;

    $index = 1;
?>

@while( $index <= $total )
    <?php
        $col = $index % $columns;
        $table_page = $index % $itemsPerPage;
        $at = $index - 1 - $offset;
    ?>
    @if( $table_page === 1 )
        <table class="page-break" cellpadding="0" cellspacing="0" width="100%" border="0">
    @endif

        @if( $col === 1 )
            <tr>
        @endif

            @if( $index <= $offset )
                <td class="main-td" style="border: 1px solid #ddd;">
                    <div class="content"></div>
                </td>
            @else
                <td class="main-td" style="border: 1px solid #ddd;">
                    <div class="content">
                        <table class="inner-table" cellpadding="0" cellspacing="0" width="100%" border="0">
                            <tr>
                                <td>{{ $people[$at]->title }}</td>
                                <td style="text-align: right;">{{ $people[$at]->id }}</td>
                            </tr>
                            
                            <tr>
                                <td colspan="2"><p class="one-line">{{ $people[$at]->name1 }}</p></td>
                            </tr>
                            
                            <tr>
                                <td colspan="2"><p class="one-line">{{ $people[$at]->name2 }}</p></td>
                            </tr>
                            
                            <tr>
                                <td colspan="2"><p class="one-line">{{ $people[$at]->address1 }}</p></td>
                            </tr>

                            <tr>
                                <td colspan="2"><p class="one-line">{{ $people[$at]->address2 }}</p></td>
                            </tr>
                            
                            <tr>
                                <td><p style="width: 110px;">{{ $people[$at]->zip_code }}</p></td>
                                <td><p class="short-line">{{ $people[$at]->city }}</p></td>
                            </tr>
                            
                            <tr>
                                <td colspan="2"><p class="one-line">{{ $people[$at]->state }}</p></td>
                            </tr>
                        </table>
                    </div>
                </td>
            @endif

        @if( $col === 0 )
            </tr>
        @endif
    
    @if( $table_page === 0 )
        </table>
    @endif

    <?php $index++; ?>
@endwhile

</body>
</html>