<style scoped>
    .images {
   display: flex;
   flex-wrap:  wrap;
   margin-top: 20px;
 }
 .images .img,
 .images .pic {
   flex-basis: 31%;
   margin-bottom: 10px;
   border-radius: 4px;
 }
 .images .img {
   width: 112px;
   height: 93px;
   background-size: cover;
   margin-right: 10px;
   background-position: center;
   display: flex;
   align-items: center;
   justify-content: center;
   cursor: pointer;
   position: relative;
   overflow: hidden;
 }
 .images .img:nth-child(3n) {
   margin-right: 0;
 }
 .images .img span {
   display: none;
   text-transform: capitalize;
   z-index: 2;
 }
 .images .img::after {
   content: '';
   width: 100%;
   height: 100%;
   transition: opacity .1s ease-in;
   border-radius: 4px;
   opacity: 0;
   position: absolute;
 }
 .images .img:hover::after {
   display: block;
   background-color: #000;
   opacity: .5;
 }
 .images .img:hover span {
   display: block;
   color: #fff;
 }
 .images .pic {
   background-color: #F5F7FA;
   align-self: center;
   text-align: center;
   padding: 40px 0;
   text-transform: uppercase;
   color: #848EA1;
   font-size: 12px;
   cursor: pointer;
 }
 </style>

 {{-- <x-dynamic-component
     class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300"
     :component="$getFieldWrapperView()"
     :id="$getId()"
     :label="$getLabel()"
     :label-sr-only="$isLabelHidden()"
     :helper-text="$getHelperText()"
     :hint="$getHint()"
     :hint-action="$getHintAction()"
     :hint-color="$getHintColor()"
     :hint-icon="$getHintIcon()"
     :required="$isRequired()"
     :state-path="$getStatePath()"
 >
 </x-dynamic-component> --}}

     {{-- <input type="file" wire:model.defer="{{ $getStatePath() }}" /> --}}

     <div class="images">
         <div class="pic">
           add
           <input type="file" wire:model.defer="{{ $getStatePath() }}" style="display:none">
         </div>
     </div>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script>
         (function ($) {
   $(document).ready(function () {

     generateID()
     choose()
     generateOption()
     selectionOption()
     removeClass()
     uploadImage()
     submit()
     resetButton()
     removeNotification()
     autoRemoveNotification()
     autoDequeue()

     var ID
     var way = 0
     var queue = []
     var fullStock = 10
     var speedCloseNoti = 1000

     function generateID() {
       var text = $('header span')
       var newID = ''

       for(var i = 0; i < 3; i++) {
         newID += Math.floor(Math.random() * 3)
       }

       ID = 'ID: 5988' + newID
       text.html(ID)
     }

     function choose() {
       var li = $('.ways li')
       var section = $('.sections section')
       var index = 0
       li.on('click', function () {
         index = $(this).index()
         $(this).addClass('active')
         $(this).siblings().removeClass('active')

         section.siblings().removeClass('active')
         section.eq(index).addClass('active')
         if(!way) {
           way = 1
         }  else {
           way = 0
         }
       })
     }

     function generateOption() {
       var select = $('select option')
       var selectAdd = $('.select-option .option')
       $.each(select, function (i, val) {
           $('.select-option .option').append('<div rel="'+ $(val).val() +'">'+ $(val).html() +'</div>')
       })
     }

     function selectionOption() {
       var select = $('.select-option .head')
       var option = $('.select-option .option div')

       select.on('click', function (event) {
         event.stopPropagation()
         $('.select-option').addClass('active')
       })

       option.on('click', function () {
         var value = $(this).attr('rel')
         $('.select-option').removeClass('active')
         select.html(value)

         $('select#category').val(value)
       })
     }

     function removeClass() {
       $('body').on('click', function () {
         $('.select-option').removeClass('active')
       })
     }

     function uploadImage() {
       var button = $('.images .pic')
       var uploader = $('<input type="file" accept="image/*" wire:model.defer="{{ $getStatePath() }}" />')
       var images = $('.images')

       button.on('click', function () {
         uploader.click()
       })

       uploader.on('change', function () {
           var reader = new FileReader()
           reader.onload = function(event) {
             images.prepend('<div class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span>remove</span></div>')
           }
           reader.readAsDataURL(uploader[0].files[0])

        })

       images.on('click', '.img', function () {
         $(this).remove()
       })

     }

     function submit() {
       var button = $('#send')

       button.on('click', function () {
         if(!way) {
           var title = $('#title')
           var cate  = $('#category')
           var images = $('.images .img')
           var imageArr = []


           for(var i = 0; i < images.length; i++) {
             imageArr.push({url: $(images[i]).attr('rel')})
           }

           var newStock = {
             title: title.val(),
             category: cate.val(),
             images: imageArr,
             type: 1
           }

           saveToQueue(newStock)
         } else {
           // discussion
           var topic = $('#topic')
           var message = $('#msg')

           var newStock = {
             title: topic.val(),
             message: message.val(),
             type: 2
           }

           saveToQueue(newStock)
         }
       })
     }

     function removeNotification() {
       var close = $('.notification')
       close.on('click', 'span', function () {
         var parent = $(this).parent()
         parent.fadeOut(300)
         setTimeout(function() {
           parent.remove()
         }, 300)
       })
     }

     function autoRemoveNotification() {
       setInterval(function() {
         var notification = $('.notification')
         var notiPage = $(notification).children('.btn')
         var noti = $(notiPage[0])

         setTimeout(function () {
           setTimeout(function () {
            noti.remove()
           }, speedCloseNoti)
           noti.fadeOut(speedCloseNoti)
         }, speedCloseNoti)
       }, speedCloseNoti)
     }

     function autoDequeue() {
       var notification = $('.notification')
       var text

       setInterval(function () {

           if(queue.length > 0) {
             if(queue[0].type == 2) {
               text = ' Your discusstion is sent'
             } else {
               text = ' Your order is allowed.'
             }

             notification.append('<div class="success btn"><p><strong>Success:</strong>'+ text +'</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
             queue.splice(0, 1)

           }
       }, 10000)
     }

     function resetButton() {
       var resetbtn = $('#reset')
       resetbtn.on('click', function () {
         reset()
       })
     }

     // helpers
     function saveToQueue(stock) {
       var notification = $('.notification')
       var check = 0

       if(queue.length <= fullStock) {
         if(stock.type == 2) {
             if(!stock.title || !stock.message) {
               check = 1
             }
         } else {
           if(!stock.title || !stock.category || stock.images == 0) {
             check = 1
           }
         }

         if(check) {
           notification.append('<div class="error btn"><p><strong>Error:</strong> Please fill in the form.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
         } else {
           notification.append('<div class="success btn"><p><strong>Success:</strong> '+ ID +' is submitted.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
           queue.push(stock)
           reset()
         }
       } else {
         notification.append('<div class="error btn"><p><strong>Error:</strong> Please waiting a queue.</p><span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></div>')
       }
     }
     function reset() {

       $('#title').val('')
       $('.select-option .head').html('Category')
       $('select#category').val('')

       var images = $('.images .img')
       for(var i = 0; i < images.length; i++) {
         $(images)[i].remove()
       }

       var topic = $('#topic').val('')
       var message = $('#msg').val('')
     }
   })
 })(jQuery)
     </script>
