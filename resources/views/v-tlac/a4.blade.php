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
        html, body { padding: 0; margin: 0; }
        * { box-sizing: border-box; }
        section { 
            @if( $columns == 2 ) 
                padding-top: 2.1cm; padding-top: 2.1cm;
            @elseif( $columns == 3 )
                padding-top: 1.3cm; padding-top: 1.3cm;
            @endif
            padding-left: .7cm; padding-right: .7cm; font-family: 'DejaVu Sans', sans-serif; font-size:12px; line-height: 1.1; letter-spacing: 0.5px; color: #ddd;
        }
        .page-break { page-break-after: always; }
        p { padding: 0; margin: 0; }
        article {
            @if( $columns == 2 )
                width: 9.8cm; max-width: 9.8cm; height: 4.2cm; padding: 1cm 0.5cm 0 1cm;
            @elseif( $columns == 3 )
                width: 6.6cm; min-width: 6.6cm; max-width: 6.6cm; height: 3.4cm; padding: 0.25cm 0.2cm 0 0.8cm;
            @endif
        }
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-1 { flex: 1; }
        .text-right {  text-align: right; }
        .one-line { width: 100%; overflow: hidden; white-space: nowrap; }
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
        <section class="page-break">
    @endif

        @if( $col === 1 )
            <div class="flex">
        @endif

            @if( $index <= $offset )
                <article class="flex-1">
                    
                </article>
            @else
                <article class="flex-1">
                    <div class="flex">
                        <div class="flex-1">{{ $people[$at]->title }}</div>

                        <div class="text-right">{{ $people[$at]->id }}</div>
                    </div>
                                   
                    <div class="one-line">{{ $people[$at]->name1 }} &nbsp;</div>
                                          
                    <div class="one-line">{{ $people[$at]->name2 }} &nbsp;</div>
                            
                    <div class="one-line">{{ $people[$at]->address1 }} &nbsp;</div>
                            
                    <div class="flex">{{ $people[$at]->address2 }} &nbsp;</div>
                            
                    <div class="flex">
                        <div style="width: 100px; overflow: hidden;">{{ $people[$at]->zip_code }}</div>
                        <div>{{ $people[$at]->city }}</div>
                    </div>        
                                    
                    <div class="flex">
                        <div class="flex-1">{{ $people[$at]->state }}</div>

                        @if( isset($people[$at]->abbreviation) )
                        <div class="text-right">
                            {{ $people[$at]->abbreviation }} {{ $people[$at]->count }}
                        </div>
                        @endif
                    </div>
                </article>
            @endif

        @if( $col === 0 )
            </div>
        @endif
    
    @if( $table_page === 0 )
        </section>
    @endif

    <?php $index++; ?>
@endwhile


<script>
    if (window.confirm("Nezabudnite pri tlači nastaviť nulové okraje!")) {
        window.print();
    }
</script>
</body>
</html>