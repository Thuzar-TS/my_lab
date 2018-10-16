<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Locations List
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
                            <tr v-for="(loca,index) in locations.data" :key="loca.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{loca.location_name}}</td>
                                <td>
                                    <label v-on:click="editLoc(loca.id, loca.location_name)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>
                                </td>
                                <td>
                                    <label v-on:click="deleteLoc(loca.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="locations" @pagination-change-page="getResults"></pagination>  
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> Locations List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(loca,index) in locations.data" :key="loca.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{loca.location_name}}</td>
                                <td>
                                    <label v-on:click="editLoc(loca.id, loca.location_name)">
                                        Edit
                                    </label>
                                </td>
                                <td>
                                    <label v-on:click="deleteLoc(loca.id, index)">
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="locations" @pagination-change-page="getResults"></pagination>                  
                </b-card> -->
            </div>
            <div class="col-md-4">
                <!-- <router-link :to="{name: 'CreateUnits'}" class="btn btn-success">Create new company</router-link> -->
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New Location</label>
                            <input type="text" class="validate form-control" required v-model="loc.location_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateLoc()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelLoc()">Cancel</label>
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
      locId: null,
      loc: {
        location_name: ""
      },
      locations: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/locations", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.locations = response.data;
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
        .get("/api/locations?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          //console.log("hello"+response.data);
          app.locations = response.data;
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
      //event.preventDefault();

      var app = this;
      if (app.loc.location_name != "" && app.loc.location_name != null) {
        var newLoc = app.loc;
        axios
          .post("/api/locations", newLoc, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New Location successfully saved.");
            app.locations = response.data;
            app.cancelLoc();
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

    editLoc(id, name) {
      //event.preventDefault();
      var app = this;
      app.loc.location_name = name;
      app.locId = id;
      app.savebtn = false;
      //console.log(app.locations);
      //edit and save button hidden true false
    },

    updateLoc() {
      var app = this;
      if (app.loc.location_name != "" && app.loc.location_name != null) {
        var edLoc = app.loc;
        console.log(app);
        axios
          .post("/api/locations/" + app.locId, edLoc, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Location successfully Edited.");
            app.cancelLoc();
            app.locations = response.data;
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

    deleteLoc(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/locations/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            alert("Location successfully deleted.");
            app.locations.data.splice(index, 1);
            app.getResults(app.pagenum);
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

    cancelLoc() {
      var app = this;
      app.savebtn = true;
      app.loc.location_name = "";
    }
  }
};
</script>