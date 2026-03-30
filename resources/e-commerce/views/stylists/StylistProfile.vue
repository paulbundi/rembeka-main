<script>
  export default {
    name: 'StylistProfile',
    props: {
      stylist: {
        type: Object,
        required: true,
      }
    },
    computed: {
      profileImage() {
        let imagePath = '/img/default.png';
        if(this.stylist.profile && this.stylist.profile.attachments.length > 0) {
          imagePath = this.stylist.profile.attachments[0].media.url;
        }
        return imagePath;
      },
    }
  };
</script>
<template>
  <div>
    <div class="d-block d-sm-none d-flex align-items-center card-body p-1">
        <img class="rounded-circle" :src="profileImage" width="150" height="150" :alt="stylist.name">
        <div class="ps-3">
            <h6 class="fs-base pt-1 mb-1">{{stylist.name}}</h6>
            <small>{{ stylist.profile.professional_qualifications}}</small>
        </div>
    </div>

    <div class="d-none d-sm-block">
      <img :src="profileImage" class="card-img-top mb-2" :alt="stylist.name">
      <h5 class="my-3 text-bolder">{{ stylist.short_description }}</h5>
  
      <p>{{ stylist.profile.professional_qualifications}}</p>
      <p>{{ stylist.profile.works_experience}}</p>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>