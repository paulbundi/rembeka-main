<script>
export default {
  name: 'UserIcon',
  props:{
    user:{
      type: Array|Object,
      required: true,
    },
    size:{
      type: String,
      default: 'avatar-sm',
    },
    context: {
      type: null,
      default: null,
    }
  },
  data() {
    return {
      colors:["#00AA55", "#009FD4", "#B381B3", "#939393", "#E3BC00", "#D47500", "#DC2A2A"],
    }
  },
  computed: {
    userAvatar() { 
        let reg = new RegExp('https?:\/\/');
      if(this.user.avatar && this.user.avatar.match(reg)){
        return this.user.avatar;
      }
      return `/storage/assets/profiles/${this.user.avatar}`
    },
    names() {
      return `${this.user.first_name} ${this.user.last_name}`;
    },
  },
  mounted() {
    this.$nextTick().then(() => {
      this.paintAvatar();
    });
  },
  methods: {
    numberFromText(text) { // numberFromText("AA");
      const charCodes = text
        .split('') // => ["A", "A"] 
        .map(char => char.charCodeAt(0)) // => [65, 65]
        .join(''); // => "6565"
      return parseInt(charCodes, 10);
    },
    paintAvatar() {
      const avatars = document.querySelectorAll('.avatar');
      avatars.forEach(avatar => {
        const text = avatar.innerText; // => "AA"
        avatar.style.backgroundColor = this.colors[this.numberFromText(text) % this.colors.length]; // => "#DC2A2A"
      });
    }
  }
}
</script>
<template>
<div v-if="user && (user.avatar || names )">
  <img v-if="user.avatar" :src="userAvatar" :class="`rounded-circle p-0 avatar ${size}`" :alt="names" data-toggle="tooltip" data-placement="top" :title="names">
  <div v-else :class="`avatar ${size}`" data-toggle="tooltip" data-placement="top" :title="names">{{(names).substring(0,1)}}
  </div>
</div>
</template>
<style scoped>

.avatar {
  width: 52px;
  height: 52px;
  background-color: #fff;
  border-radius: 50%;
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-transform: uppercase;
}
.avatar-xs {
  width: 29px;
  height: 29px;
}
.avatar-sm {
  width: 38px;
  height: 38px;
}
.avatar-md {
  width: 50px;
  height: 50px;
}
.avatar-lg {
  width: 80px;
  height: 80px;
}
.avatar-xl {
  width: 100px;
  height: 100px;
}
  /* Tooltip text */
.avatar .tooltiptext, .avatar-sm .tooltiptext {
visibility: hidden;
width: 120px;
background-color: black;
color: #fff;
text-align: center;
padding: 5px 0;
border-radius: 6px;

/* Position the tooltip text - see examples below! */
position: absolute;
z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.avatar:hover .tooltiptext, .avatar-sm:hover .tooltiptext  {
visibility: visible;
}
</style>