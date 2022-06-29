<template>
  <div>
    <v-card v-if="!loading" height="100vh" class="pa-1 profile-card">
      <div class="banner">
        <v-img
          class="cover-photo"
          src="@/assets/images/wallpapers/nature1.jpg"
          height="40vh"
        ></v-img>
        <v-avatar class="avatar-photo rounded-gradient-border" size="25vh">
          <v-img v-if="profile.photo" :src="avatar_path(profile.photo)"></v-img>
          <v-img
            v-else
            :src="
              require(profile.gender == 1
                ? './../assets/images/man.png'
                : './../assets/images/woman.png')
            "
          ></v-img>
        </v-avatar>
        <span class="profile-name">{{ profile.full_name }}</span>
      </div>
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'ProfileComponent',
  data: () => ({
    loading: false,
    user_id: 0,
    profile: {
      full_name: '',
      cpf: '',
      email: '',
      gender: '',
      role: '',
      active: '',
      access: '',
      photo: '',
    },
  }),
  created() {
    this.loadProfile();
  },
  methods: {
    loadProfile() {
      this.loading = true;
      this.user_id = this.$route.params.id;
      this.$http
        .post('get_profile', { user_id: this.user_id })
        .then((response) => {
          response.data.access = response.data.access.name;
          Object.assign(this.profile, response.data);
          console.log(this.profile);
          this.loading = false;
        });
    },
    avatar_path(photo_path) {
      return require('../../../backend/storage/app/' + photo_path);
    },
  },
};
</script>

<style scoped>
.profile-name {
  font-weight: bold;
  color: white;
  text-shadow: 1px 1px black;
  position: absolute;
  font-size: 4vh;
  bottom: 2vh;
  left: 40vh;
}
.cover-photo {
  border-radius: 5px;
}
.rounded-gradient-border {
  width: 300px;
  height: 80px;
  border: double 4px transparent;
  border-radius: 100%;
  background-image: linear-gradient(rgb(9, 52, 95), rgb(56, 195, 32)),
    radial-gradient(
      circle at top left,
      rgb(107, 205, 54),
      rgb(46, 115, 168),
      rgb(177, 195, 17)
    );
  background-origin: border-box;
  background-clip: content-box, border-box;
}
.banner {
  position: relative;
}
.avatar-photo {
  position: absolute;
  bottom: -10vh;
  left: 10vh;
}
.profile-card {
  box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset,
    rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset,
    rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px,
    rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px,
    rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px !important;
}
</style>