$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#manga-cover').on('change',()=>{
    var formData = new FormData();
    var file = $('#manga-cover')[0].files[0]
    formData.append('file',file)
    $.ajax({
        url : '/upload',
        processData: false,//illega invocation
        dataType: 'json',
        data: formData,
        method: 'POST',
        contentType: false,// khong hien o preview
        success: function(result){
            if(result.success == true)
            {
                // html = '';
                // html+= '<img src="'+result.path+'" alt="">';
                // $('#input-file-img').html(html)
                $('#manga-cover-hidden').val(result.path)
            }
        }
    })
})

$('#chapter-images').on('change',()=>{
    var formData = new FormData()
    var files = $('#chapter-images')[0].files
    for (let index = 0; index < files.length; index++) {
        formData.append('files[]',files[index])
    }
    $.ajax({
        url:'/uploads',
        method: 'POST',
        dataType: 'JSON',
        data: formData,
        contentType: false,
        processData: false,
        success:function(result){
            if(result.success === true)
            {
                let html = '';
                for (let index = 0; index < result.paths.length; index++) {
                    html += '<input type="hidden" value="'+result.paths[index]+'" class="product-images" name="images[]">';
                }
                // Thêm vào thay vì ghi đè
                $('#input-file-imgs').append(html);
                
                // Tùy chọn: hiển thị số lượng ảnh đã upload
                console.log('Tổng số ảnh đã upload: ' + $('.product-images').length);
            }
        }
    })
})

