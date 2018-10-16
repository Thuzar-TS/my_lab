<template>
  <div class="animated fadeIn">
    This is Dashboard.
    {{data}}
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: "nothing"
    };
  },
  mounted() {
    axios
      .get("/api/dashboard", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response);
        this.data = response.data.data;
      })
      .catch(error => {
       
        if (error.response.data.message == "Unauthenticated.") {
          localStorage.removeItem("token");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
        //  this.$route.router.go('/');
          
        }
      });
  }
};
</script>
