
@if ($paginator->hasPages())
    <!-- Pagination --> 
    <div>  
        <ul style="height:30px;" class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span><<</span>
                </li>
                <li class="disabled">
                    <span><</span>
                </li>                
            @else
                <li>
                    <a href="{{ $paginator->toArray()['first_page_url'] }}">
                        <span><<</span>
                    </a>
                </li>
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}">
                        <span><</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>                        
                        @elseif ($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2 || $page == $paginator->currentPage()+7 || $page == $paginator->currentPage()+8 || $page == $paginator->currentPage()+9 )
                            <li><a href="{{ $url }}">{{$page }}</a></li>
                        @elseif ($page == $paginator->currentPage() +5) 
                            <li class="disabled"><span><i class="fa fa-ellipsis-h"></i></span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <span>></span>
                    </a>
                </li>
                <li>
                    <a href="{{ $paginator->toArray()['last_page_url'] }}">
                        <span >>></span>
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span>
                        >
                    </span>
                </li>
                <li class="disabled">
                    <span>>></span>
                </li>
            @endif
            
        </ul> 
</div>

<style>

.pagination { /*class defaut pagination*/
    width: 60%;
    height: 40px;
    margin-top: 2px;
    margin-left: 200px;  }


.pagination li:first-child, .pagination li:nth-child(2),
 .pagination li:nth-last-child(2),.pagination li:last-child {
    font-weight: bold;
}

</style>
    <!-- Pagination -->
    
@endif