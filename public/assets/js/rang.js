function RangeSlide(elemRang) {
   this.cords={};
   this.check={'click':true,'moveFlag':false};

   this.target=false;
   this.inputVal={
     'min':elemRang.find('input:first'),
     'max':elemRang.find('input:last')
   };
   this.val={
     'min': this.inputVal.min.val(),
     'max':this.inputVal.max.val(),
     'currentMin':this.inputVal.min.val(),
     'currentMax':this.inputVal.max.val(),
   };
   this.middleElem=elemRang.find('#middle-range');
   this.width={
                 'firstRange':elemRang.find('#first-range').width(),
                 'widthMiddleElem':this.middleElem.width(),
                 'leftElem':parseInt(this.middleElem.css('left')),
                 'rightElem':parseInt(this.middleElem.css('width'))+parseInt(this.middleElem.css('left'))
               };

 this.range=function(){

   if(!this.check.click){

     if(this.target.is('#right-val')){
        this.setWidth('right');

     }else if(this.target.is('#left-val')) {
        this.setWidth('left');
     }
   }else{
     this.setWidth('click');
   }
   this.middleElem.css({
     'right':this.width.firstRange-this.width.rightElem+'px',
     'left':this.width.leftElem+'px'
   });
  this.inputVal.min.val(Math.floor(this.val.currentMin));
  this.inputVal.max.val(Math.floor(this.val.currentMax));

 }
 this.setWidth=function(type){
   var rangeWidth=this.width.firstRange;
   var leftMarggin=elemRang.find('#first-range').offset().left;
   this.width.widthMiddleElem=this.middleElem.width();
   if(type==='right'){
     if(this.cords.x<leftMarggin+this.width.leftElem+15){
            this.width.rightElem=this.width.leftElem+15;
            this.val.currentMax= this.val.currentMin+1;

     }else if (this.cords.x >= this.width.firstRange+leftMarggin) {
           this.width.rightElem=this.width.firstRange;
           this.val.currentMax= this.val.max;
     }else {

       this.width.rightElem=this.cords.x-leftMarggin;
       this.val.currentMax= this.width.rightElem*this.val.max/this.width.firstRange;
     }

 }else if (type==='left') {
   if(this.cords.x<leftMarggin){
          this.width.leftElem=0;
          this.val.currentMin= 0;

   }else if (this.cords.x >= this.width.firstRange-(this.width.firstRange-this.width.rightElem)+leftMarggin-15) {
         this.width.leftElem=this.width.firstRange-(this.width.firstRange-this.width.rightElem)-15;
         this.val.currentMin= this.val.max-1;
   }else {
     this.width.leftElem=this.cords.x-leftMarggin;
     this.val.currentMin= (this.width.leftElem*(this.val.min==0 ? 1 : this.val.min)/this.width.firstRange)*this.val.max;
   }

 }else if (type==='click') {

       if(this.cords.x-leftMarggin>=0 && this.cords.x-leftMarggin<=(this.width.widthMiddleElem/2+this.width.leftElem)){
         this.width.leftElem=this.cords.x-leftMarggin;
         this.val.currentMin= (this.width.leftElem*(this.val.min==0 ? 1 : this.val.min)/this.width.firstRange)*this.val.max;

       }else if(this.cords.x-leftMarggin>(this.width.widthMiddleElem/2+this.width.leftElem) && this.cords.x-leftMarggin<=this.width.firstRange) {
         this.width.rightElem=this.cords.x-leftMarggin;
         this.val.currentMax= this.width.rightElem*this.val.max/this.width.firstRange;
       }
 }

 }
 this.down=function(target){
   this.check.moveFlag=true;
   this.target=$(target.target);
   this.cords.x=target.clientX;
   this.cords.y=target.clientY;
   this.check.click=true;
   this.range();
 }

this.move=function (x,y) {

    if(this.cords.x!=x){
      this.check.click=false;
      this.cords.x=x;
      this.cords.y=y;
      this.range();
    }
 }

 this.downup=function(){
   this.check.moveFlag=0;
   this.check.click=true;
 }

 this.change=function(input){
   if(/^\d+$/.test(input.val())){
     if(input.attr('data')=='min'){
       if(parseInt(input.val())>=0 && (parseInt(input.val())<this.val.currentMax)){
         this.val.currentMin=input.val();
         this.width.leftElem=input.val()*this.width.firstRange/this.val.max;
         this.range();
       }else {
         this.width.leftElem=0
         input.val(this.val.currentMin);
       }
     }else {
       if(parseInt(input.val())>=this.val.currentMin && (parseInt(input.val())<=this.val.max)){
         this.val.currentMax=input.val();
         this.width.rightElem=input.val()*this.width.firstRange/this.val.max;
         this.range();
       }else {
         this.width.rightElem=0;
         input.val(this.val.currentMax);
       }
     }

   }else {

     if(input.attr('data')=='min'){
       input.val('');
     }else {
        input.val('');
     }
     if(input.val()== ''){
       input.val(0);
     }
   }
 }
}

var range=false;
$(document).on({
 mousedown:function(e){
   if($(e.target).closest('#range').length && !range){
     range=new RangeSlide($('#range'));
   }
   if($(e.target).closest('#first-range').length){
      range.down(e);
   }

 },
 mouseup:function(e){
   if(range){
  range.downup();
  }
 },
 mousemove:function(e){
   if(range){
     if(range.check.moveFlag){
       range.move(e.clientX,e.clientY);
     }
   }
 },
keyup:function(e){

   if($(e.target).closest('#range').length){

      range.change($(e.target));
   }

 }
});
