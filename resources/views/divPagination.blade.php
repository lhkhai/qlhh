<div class="div_pagination">
      <div class='perpage'>
        <!-- If the variable $current_url exists then url=$current_url otherwise url=url()->current() -->
        <form  action= "{{ isset($current_url) ? asset($current_url) : url()->current() }}" method="GET"> 
          <span>Chọn số dòng/trang:</span>    
            <select id='perpage' name="perpage" onchange="this.form.submit()">
                <option value=10>10</option> 
                <option value=20>20</option> 
                <option value=50>50</option> 
                <option value=100>100</option> 
            </select>
            @isset($search)
              <?php
              $data_search ="";
              for($i=0;$i<count($search);$i++)
                if($i<count($search)-1)
                $data_search .= $search[$i].',';
                else $data_search .=$search[$i]; 
                ?>  
              <input type="hidden" name="search[]" value="{{$data_search}}"/>         
              @endif        
        </form>   
      </div>
      @if(isset($dataview))
      {{$dataview->appends(request()->all())->links('pagination')}}      
        <div class='total_record' >
          Tổng: {{$dataview->total()}} dòng, {{$dataview->lastPage()}} trang
        </div> 
      @endif 
      @if(isset($perPage))
      <script>$("#perpage").val('{{$perPage}}')</script> <!-- Set selectbox value -->      
      @endif  
  </div>