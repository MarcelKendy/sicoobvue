<template>
<div class="brighten">
  <img class="top" src="../assets/images/marca_sicoob_branca.png" width="402" alt="">
  
</div>
               
        
</template>

<script>
  export default {
    name: 'CardWelcomeComponent',
    computed: {
     
    },
    methods: {
     
    },
    data: () => ({
    })
  }
</script>
<style scoped>
  .top {
    position: absolute;
    left: 49.7%;
    top:10%;
    transform: translate(-50%, -50%);
    padding: 10px;
  }
  .hover-card {
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px !important; 
    
    transition: box-shadow .3s;
  }
  .hover-card:hover {
    box-shadow: rgba(0, 0, 0, 0.3) 0px 39px 68px, rgba(0, 0, 0, 0.22) 0px 35px 32px !important; 
  }

.brighten img {
  transition: 400ms;
    opacity: 1;
}

.brighten img:hover {
    opacity: 0.6;
}
</style>
<style lang="scss">
  

  .gamer-border {
	--angle: 0deg;
	
	border: 2px solid;
	border-image: conic-gradient(from var(--angle),rgb(253, 249, 1) , rgb(10, 255, 2), rgb(121, 178, 253),rgba(18,210,175)) 1;
	
	animation: 10s rotate linear infinite;
}

@keyframes rotate {
	to {
		--angle: 360deg;
	}
}

@property --angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}

</style>