<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Radiologics List <span class='badge badge-primary float-right add-btn' v-on:click='newRad()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
                    </div>
                    <div class="card-block">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width:250px;">&nbsp;</th>
                                    <th>NRC</th>
                                    <th>Department</th>
                                    <th>D.O.B</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rad,index) in radiologics.data" :key="rad.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td>
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{rad.radiologic_name}}</a>&nbsp;
                                        <i class="icon-user-female icons" v-if="rad.gender=='2'" style="font-size:0.9em;color:#f90bab;font-weight:bold;"></i>
                                        <i class="icon-user icons" v-if="rad.gender=='1'" style="font-size:0.9em;color:blue;font-weight:bold;"></i>
                                        <br>
                                        <span class=" tbl-btn tbl-btn-gold" style="font-size:0.9em;font-weight:normal;letter-spacing: 1px;">
                                        {{rad.licence_number}}
                                        </span>
                                        <br>
                                        <span style="font-size:0.9em;color:#0f56d8;font-weight:normal;">{{rad.degree}}</span><br>
                                        <span style="font-size:0.9em;color:#0f56d8;font-weight:normal;">{{rad.specialization}}</span><br>
                                        <a title="edit" v-on:click="editRad(rad.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteRad(rad.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>   
                                    </td>
                                    <td style="font-size:0.9em;">{{rad.nrc}}</td>
                                    <td>{{rad.department}}</td>
                                    <td>{{rad.dob}}</td>                                
                                    <td>{{rad.address}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="radiologics" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New radiologic</label>
                            <input type="text" class="validate form-control" required v-model="rad.radiologic_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateRad()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelRad()">Cancel</label>
                    </div>
                </form>
            </div> -->
        </div>
        <div class="col-sm-8 offset-sm-2" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateRad()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>Radiologic Setup <i v-on:click="cancelRad()" class="fa fa-close float-right closebtn"></i>
                </div>
                <!-- <div class="card-block">
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New radiologic</label>
                            <input type="text" class="validate form-control" required v-model="rad.radiologic_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    
                </div> -->
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="radiologic">Radiologic's Name</label>
                                <input placeholder="Name" required v-model="rad.radiologic_name" type="text" class="validate form-control">                          
                            </div>
                            
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="radio1">
                                    <input type="radio" id="radio1" v-model="rad.gender" value="1"> Male
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="radio2">
                                    <input type="radio" id="radio2" v-model="rad.gender" value="2"> Female
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>

                            <div class="form-group" id="date">
                                <label for="dob">Date of Birth</label>
                                <datepicker v-model="rad.dob" :format="customFormatter"></datepicker>
                            </div>

                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input v-model="rad.mobile" placeholder="Mobile Number" id="mobile" type="text" class="validate form-control">                          
                            </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group">
                                <label for="nrc">NRC Number</label>
                                <input v-model="rad.nrc" required placeholder="National card number" id="nrc" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="degree">Degree</label>
                                <input v-model="rad.degree" required placeholder="Degree" id="degree" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input v-model="rad.specialization" placeholder="Your specialization" id="specialization" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="licence_number">Licence Number</label>
                                <input v-model="rad.licence_number" required placeholder="radiologic Licence Number" id="licence_number" type="text" class="validate form-control">                          
                            </div>                           
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input v-model="rad.department" required placeholder="Department Name" id="department" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="referred_percent">Referred (%)</label>
                                <input v-model="rad.referred_percent" placeholder="Only in number" id="referred_percent" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="rank">Rank</label>
                                <input v-model="rad.rank" id="rank" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label>Show In Result</label>
                                <div class="row">               
                                    <div class="col-sm-6">
                                    <div class="radio">
                                    <label for="radio3">
                                        <input type="radio" id="radio3" v-model="rad.show_in_result" value="1"> Show
                                    </label>
                                    </div>  
                                </div>
                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label for="radio4">
                                            <input type="radio" id="radio4" v-model="rad.show_in_result" value="2"> Not
                                        </label>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="address">Address</label>
                            <textarea v-model="rad.address" placeholder="Details in address" id="address" rows="3" class="validate form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <!-- <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()"><i class="fa fa-save"></i> Save</label> -->
                    <!-- <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateRad()">Edit</label> -->
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelRad()">Cancel</label>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
window.moment = require("moment");

export default {
  components: {
    Datepicker
  },
  data: function() {
    return {
      pagenum: 1,
      showsetup: false,
      savebtn: true,
      radId: null,
      rad: {
        radiologic_name: "",
        nrc: "",
        gender: 1,
        dob: new Date(),
        mobile: "",
        address: "",
        degree: "",
        specialization: "",
        licence_number: "",
        department: "",
        referred_percent: "",
        rank: "",
        show_in_result: 1
      },
      radiologics: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/radiologics", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.radiologics = response.data;
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
    customFormatter(date) {
      return moment(String(date)).format("MM-DD-YYYY");
    },
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/radiologics?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.radiologics = response.data;
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

    newRad() {
      this.cancelRad();
      this.showsetup = true;
    },

    saveForm() {
      var app = this;
      var newRad = app.rad;
      axios
        .post("/api/radiologics", newRad, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
            alert("New Radiologic successfully Saved.");
          app.radiologics = response.data;
          app.cancelRad();
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

    editRad(id) {
      this.showsetup = true;
      var app = this;
      app.radId = id;
      app.savebtn = false;
      axios
        .get("/api/radiologics/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.rad = response.data;
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

    updateRad() {
      var app = this;
      var edrad = app.rad;
      axios
        .post("/api/radiologics/" + app.radId, edrad, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("Radiologic successfully edited.");
          app.cancelRad();
          app.radiologics = response.data;
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

    deleteRad(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/radiologics/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            alert("Radiologic successfully deleted.");
            app.radiologics.data.splice(index, 1);
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

    cancelRad() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.rad.radiologic_name = "";
      app.rad.nrc = "";
      app.rad.gender = 1;
      app.rad.dob = "";
      app.rad.mobile = "";
      app.rad.address = "";
      app.rad.degree = "";
      app.rad.specialization = "";
      app.rad.licence_number = "";
      app.rad.department = "";
      app.rad.referred_percent = "";
      app.rad.rank = "";
      app.rad.show_in_result = 1;
    }
  }
};
</script>