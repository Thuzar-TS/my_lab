<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Doctors List <span class='badge badge-primary float-right add-btn' v-on:click='newDoc()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
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
                                <tr v-for="(doc,index) in doctors.data" :key="doc.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td style="width:250px;">
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{doc.doctor_name}}</a>&nbsp;
                                        <i class="icon-user-female icons" v-if="doc.gender=='2'" style="font-size:0.9em;color:#f90bab;font-weight:bold;"></i>
                                        <i class="icon-user icons" v-if="doc.gender=='1'" style="font-size:0.9em;color:blue;font-weight:bold;"></i>
                                        <br>
                                        <span class=" tbl-btn tbl-btn-gold" style="font-size:0.9em;font-weight:normal;letter-spacing: 1px;">
                                        {{doc.licence_number}}
                                        </span>
                                        <br>
                                        <span style="font-size:0.9em;color:#0f56d8;font-weight:normal;">{{doc.degree}}</span><br>
                                        <span style="font-size:0.9em;color:#0f56d8;font-weight:normal;">{{doc.specialization}}</span><br>
                                        <a title="edit" v-on:click="editDoc(doc.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteDoc(doc.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger  badge-del-btn">
                                        Delete
                                        </span></a>   
                                    </td>
                                    <td style="font-size:0.9em;">{{doc.nrc}}</td>
                                    <td>{{doc.department}}</td>
                                    <td>{{doc.dob}}</td>                                
                                    <td>{{doc.address}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="doctors" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 offset-sm-2" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateDoc()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>Doctor Setup <i v-on:click="cancelDoc()" class="fa fa-close float-right closebtn"></i>
                </div>
               
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="doctor">Doctor's Name</label>
                                <input placeholder="Name" required v-model="doc.doctor_name" type="text" class="validate form-control">                          
                            </div>
                            
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="radio1">
                                    <input type="radio" id="radio1" v-model="doc.gender" value="1"> Male
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="radio2">
                                    <input type="radio" id="radio2" v-model="doc.gender" value="2"> Female
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>

                            <div class="form-group" id="date">
                                <label for="dob">Date of Birth</label>
                                <datepicker v-model="doc.dob" :format="customFormatter"></datepicker>
                            </div>

                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input v-model="doc.mobile" placeholder="Mobile Number" id="mobile" type="text" class="validate form-control">                          
                            </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group">
                                <label for="nrc">NRC Number</label>
                                <input v-model="doc.nrc" required placeholder="National card number" id="nrc" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="degree">Degree</label>
                                <input v-model="doc.degree" required placeholder="Degree" id="degree" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input v-model="doc.specialization" placeholder="Your specialization" id="specialization" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="licence_number">Licence Number</label>
                                <input v-model="doc.licence_number" required placeholder="Doctor Licence Number" id="licence_number" type="text" class="validate form-control">                          
                            </div>                           
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input v-model="doc.department" required placeholder="Department Name" id="department" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="referred_percent">Referred (%)</label>
                                <input v-model="doc.referred_percent" placeholder="Only in number" id="referred_percent" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label for="rank">Rank</label>
                                <input v-model="doc.rank" id="rank" type="text" class="validate form-control">                          
                            </div>
                            <div class="form-group">
                                <label>Show In Result</label>
                                <div class="row">               
                                    <div class="col-sm-6">
                                    <div class="radio">
                                    <label for="radio3">
                                        <input type="radio" id="radio3" v-model="doc.show_in_result" value="1"> Show
                                    </label>
                                    </div>  
                                </div>
                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label for="radio4">
                                            <input type="radio" id="radio4" v-model="doc.show_in_result" value="2"> Not
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
                            <textarea v-model="doc.address" placeholder="Details in address" id="address" rows="3" class="validate form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelDoc()">Cancel</label>
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
      docId: null,
      doc: {
        doctor_name: "",
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
      doctors: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/doctors", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.doctors = response.data;
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
        .get("/api/doctors?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.doctors = response.data;
          console.log(app.doctors.length);
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

    newDoc() {
      this.cancelDoc();
      this.showsetup = true;
    },

    saveForm() {
      var app = this;
      var newdoc = app.doc;
      axios
        .post("/api/doctors", newdoc, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("New Doctor Successfully Saved.");
          app.doctors = response.data;
          app.cancelDoc();
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

    editDoc(id) {
      this.showsetup = true;
      var app = this;
      app.docId = id;
      app.savebtn = false;
      axios
        .get("/api/doctors/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.doc = response.data;
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

    updateDoc() {
      var app = this;
      var eddoc = app.doc;
      console.log("eddoc" + eddoc);
      console.log("docid" + app.docId);
      axios
        .post("/api/doctors/" + app.docId, eddoc, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("Your Doctor Successfully Edited.");
          app.cancelDoc();
          app.doctors = response.data;
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

    deleteDoc(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/doctors/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.doctors.data.splice(index, 1);
            alert("Doctor Successfully Deleted.");
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

    cancelDoc() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.doc.doctor_name = "";
      app.doc.nrc = "";
      app.doc.gender = 1;
      app.doc.dob = "";
      app.doc.mobile = "";
      app.doc.address = "";
      app.doc.degree = "";
      app.doc.specialization = "";
      app.doc.licence_number = "";
      app.doc.department = "";
      app.doc.referred_percent = "";
      app.doc.rank = "";
      app.doc.show_in_result = 1;
    }
  }
};
</script>