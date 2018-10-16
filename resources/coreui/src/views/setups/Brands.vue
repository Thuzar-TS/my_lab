<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Brands List
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
                            <tr v-for="(bran,index) in brands.data" :key="bran.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{bran.brand_name}}</td>
                                <td>
                                    <label v-on:click="editBran(bran.id, bran.brand_name)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>                                  
                                </td>
                                <td>
                                    <label v-on:click="deleteBran(bran.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="brands" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
            </div>
            <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New brand</label>
                            <input type="text" class="validate form-control" v-model="bran.brand_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateBran()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelBran()">Cancel</label>
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
      branId: null,
      bran: {
        brand_name: ""
      },
      brands: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/brands", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response.data);
        app.brands = response.data;
      })
      .catch(error => {
        console.log(error.response);
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
        .get("/api/brands?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.brands = response.data;
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
      if (app.bran.brand_name != "" && app.bran.brand_name != null) {
        var newbran = app.bran;
        axios
          .post("/api/brands", newbran, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New brand successfully saved.");
            app.brands = response.data;
            app.cancelBran();
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

    editBran(id, name) {
      //event.preventDefault();
      var app = this;
      app.bran.brand_name = name;
      app.branId = id;
      app.savebtn = false;
      //console.log(app.brands);
      //edit and save button hidden true false
    },

    updateBran() {
      var app = this;
      if (app.bran.brand_name != "" && app.bran.brand_name != null) {
        var edbran = app.bran;
        console.log(app);
        axios
          .post("/api/brands/" + app.branId, edbran, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Brand successfully edited.");
            app.cancelBran();
            app.brands = response.data;
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

    deleteBran(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/brands/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.brands.data.splice(index, 1);
            //app.getResults(app.pagenum);
            alert("Brand successfully deleted.");
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

    cancelBran() {
      var app = this;
      app.savebtn = true;
      app.bran.brand_name = "";
    }
  }
};
</script>