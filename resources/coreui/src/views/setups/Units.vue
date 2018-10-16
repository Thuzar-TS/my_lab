<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Units List
                </div>
                <div class="card-block">
                  <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(uni,index) in units.data" :key="uni.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{uni.unit_name}}</td>
                                <td>
                                    <label v-on:click="editUni(uni.id, uni.unit_name)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>
                                    <!-- <router-link :to="{name: 'edituni', params: {id: uni.id}}" class="btn btn-xs btn-default">
                                        Edit
                                    </router-link> -->
                                </td>
                                <td>
                                    <label v-on:click="deleteUni(uni.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="units" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> Units List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(uni,index) in units.data" :key="uni.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{uni.unit_name}}</td>
                                <td>
                                    <label v-on:click="editUni(uni.id, uni.unit_name)">
                                        Edit
                                    </label>
                                </td>
                                <td>
                                    <label v-on:click="deleteUni(uni.id, index)">
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="units" @pagination-change-page="getResults"></pagination>                  
                </b-card> -->
            </div>
            <div class="col-md-4">
                <!-- <router-link :to="{name: 'CreateUnits'}" class="btn btn-success">Create new company</router-link> -->
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New Unit</label>
                            <input type="text" class="validate form-control" v-model="uni.unit_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateUni()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelUni()">Cancel</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
//import pagination from 'laravel-vue-pagination'
//  Vue.component('pagination', require('laravel-vue-pagination'));
export default {
  //   component: pagination,
  data: function() {
    return {
      pagenum: 1,
      savebtn: true,
      uniId: null,
      uni: {
        unit_name: ""
      },
      units: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/units", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response.data);
        app.units = response.data;
      })
      .catch(error => {
        if (error.response.data.message == "Unauthenticated.") {
          localStorage.removeItem("token");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
          alert("Session Expired. <br>Please Login Again.");
        }
      });
  },
  methods: {
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/units?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.units = response.data;
        })
        .catch(error => {
          if (error.response.data.message == "Unauthenticated.") {
            localStorage.removeItem("token");
            store.commit("logoutUser");
            this.$router.push({ name: "login" });
            alert("Session Expired. <br>Please Login Again.");
          }
        });
    },

    saveForm() {
      var app = this;
      if (app.uni.unit_name != "" && app.uni.unit_name != null) {
        var newuni = app.uni;
        axios
          .post("/api/units", newuni, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New Unit successfully saved.");
            app.units = response.data;
            app.cancelUni();
          })
          .catch(error => {
            if (error.response.data.message == "Unauthenticated.") {
              localStorage.removeItem("token");
              store.commit("logoutUser");
              this.$router.push({ name: "login" });
              alert("Session Expired. <br>Please Login Again.");
            }
          });
      } else {
        alert("Please Fill Compelety.");
      }
    },

    editUni(id, name) {
      var app = this;
      app.uni.unit_name = name;
      app.uniId = id;
      app.savebtn = false;
    },

    updateUni() {
      var app = this;
      if (app.uni.unit_name != "" && app.uni.unit_name != null) {
        var eduni = app.uni;
        console.log(eduni);
        axios
          .post("/api/units/" + app.uniId, eduni, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Unit successfully edited.");
            app.cancelUni();
            app.units = response.data;
          })
          .catch(error => {
            if (error.response.data.message == "Unauthenticated.") {
              localStorage.removeItem("token");
              store.commit("logoutUser");
              this.$router.push({ name: "login" });
              alert("Session Expired. <br>Please Login Again.");
            }
          });
      } else {
        alert("Please Fill Compelety.");
      }
    },

    deleteUni(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/units/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.units.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("Unit successfully deleted.");
          })
          .catch(error => {
            if (error.response.data.message == "Unauthenticated.") {
              localStorage.removeItem("token");
              store.commit("logoutUser");
              this.$router.push({ name: "login" });
              alert("Session Expired. <br>Please Login Again.");
            }
          });
      }
    },

    cancelUni() {
      var app = this;
      app.savebtn = true;
      app.uni.unit_name = "";
    }
  }
};
</script>