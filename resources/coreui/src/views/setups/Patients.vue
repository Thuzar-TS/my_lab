<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Patients List <span class='badge badge-primary float-right add-btn' v-on:click='newPat()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
                    </div>
                    <div class="card-block">                        
                        <!-- <datepicker v-model="pat.dob" name="uniquename" :format="customFormatter"></datepicker>{{pat.dob}} -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width:250px">&nbsp;</th>
                                    <th style="width:300px">&nbsp;</th>
                                    <th style="width:200px;">&nbsp;</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pat,index) in patients.data" :key="pat.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td>
                                        
                                        <i class="icon-user-female icons" v-if="pat.gender=='2'"  style="font-size:0.9em;color:#f90bab;font-weight:bold;"></i>
                                        <i class="icon-user icons" v-if="pat.gender=='1'" style="font-size:0.9em;color:blue;font-weight:bold;"></i>
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{pat.patient_name}}</a>&nbsp;
                                        <span v-if="pat.patientstatus==1" class="float-right" style="color:orange;font-size:0.9em;">
                                        <i class="fa fa-hospital-o"></i> Inpatient</span>
                                        <span v-if="pat.patientstatus==2" class="float-right" style="color:orange;font-size:0.9em;">
                                        <i class="fa fa-hospital-o"></i> OPD</span>
                                        <br>
                                        <span class="badge badge-success tbl-btn tbl-btn-success" style="letter-spacing: 1px;font-weight:bold;">
                                        {{pat.patient_reference}}
                                        </span>
                                        <!-- <span class=" tbl-btn tbl-btn-gold" style="font-size:0.9em;font-weight:normal;letter-spacing: 1px;">
                                        {{pat.patient_reference}}
                                        </span> -->
                                        <span style="color:red;font-size:0.9em;">[ {{pat.blood_type}} Blood ]</span>
                                        <br>
                                        <span style="font-size:0.9em;font-weight:normal;">
                                            <i class="fa fa-calendar" style="color:blue"></i> {{pat.dob}} ({{pat.age}} years)</span><br>
                                        <span style="font-size:0.9em;font-weight:normal;">{{pat.occupation}} ({{pat.marital_status}})</span> 
                                        <br><br>
                                        <!-- <span v-if="pat.allergy==0" style="color:red;font-weight:bold;font-size:0.9em;">Allergy</span><br> -->
                                        <a title="edit" v-on:click="editPat(pat.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deletePat(pat.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>  <span v-if="pat.allergy==1" class="float-right" style="color:red;font-size:0.9em;">
                                        <i class="fa fa-check"></i> Allergy</span> 
                                        <span v-if="pat.allergy==0" class="float-right" style="color:#ccc;font-size:0.9em;">
                                        <i class="fa fa-close"></i> Allergy</span> 
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="fa fa-phone" style="color:blue;"></i> {{pat.phone}}<br>
                                        <i class="fa fa-home" style="color:blue;"></i> {{pat.address}}<br>
                                        <i class="fa fa-map-marker" style="color:blue;"></i> {{pat.city}}<br>
                                        <i class="fa fa-envelope" style="color:blue;"></i> {{pat.email}}<br>
                                        <i class="fa fa-print" style="color:blue;"></i> {{pat.fax}}
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="icon-user icons" style="font-size:0.9em;font-weight:bold;color:blue;"></i> {{pat.father_name}}<br>
                                        <i class="icon-user-female icons" style="font-size:0.9em;font-weight:bold;color:#f90bab;"></i> {{pat.mother_name}}<br><br>
                                        {{pat.nationality}}<br>
                                        {{pat.religion}}
                                    </td>
                                    <td>{{pat.remark}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="patients" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New patient</label>
                            <input type="text" class="validate form-control" required v-model="pat.patient_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updatePat()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelPat()">Cancel</label>
                    </div>
                </form>
            </div> -->
        </div>
        <div class="col-sm-10" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updatePat()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>Patient Setup <i v-on:click="cancelPat()" class="fa fa-close float-right closebtn"></i>
                </div>
                <!-- <div class="card-block">
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New patient</label>
                            <input type="text" class="validate form-control" required v-model="pat.patient_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    
                </div> -->
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="patient">Reference Number</label>
                                <input placeholder="Reference" required v-model="pat.patient_reference" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="patient">Patient's Name</label>
                                <input placeholder="Name" required v-model="pat.patient_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="patient">NRC</label>
                                <input placeholder="NRC" required v-model="pat.nrc" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <!-- <label>Gender</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="mradio">
                                    <input type="radio" id="mradio" v-model="pat.gender" value="1"> Male
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="fradio">
                                    <input type="radio" id="fradio" v-model="pat.gender" value="2"> Female
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group" id="date">
                                        <label for="dob">Date of Birth</label>
                                        <datepicker v-model="pat.dob" :format="customFormatter"></datepicker>
                                        <!-- <input v-model="pat.dob" id="dob" type="text" class="validate form-control">  -->
                                    </div>
                                </div>
                                <div class="col-sm-3" style="padding-left:0px;">
                                    <div class="form-group">
                                        <label for="age">Age</label>
                                        <input v-model="pat.age" id="age" required type="text" class="validate form-control">                          
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <!-- <label>Marital Status</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="sradio">
                                    <input type="radio" id="sradio" v-model="pat.marital_status" value="Single"> Single
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="maradio">
                                    <input type="radio" id="maradio" v-model="pat.marital_status" value="Married"> Married
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Blood Type</label>
                                <div class="row">               
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="ablood">
                                                <input type="radio" id="ablood" v-model="pat.blood_type" value="A"> A
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="bblood">
                                                <input type="radio" id="bblood" v-model="pat.blood_type" value="B"> B
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="abblood">
                                                <input type="radio" id="abblood" v-model="pat.blood_type" value="AB"> AB
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="oblood">
                                                <input type="radio" id="oblood" v-model="pat.blood_type" value="O"> O
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="pat.allergy" style="cursor:pointer;">Allergy</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>

                            <div class="form-group">                                
                                <!-- <label>Patient Status</label> -->
                                <div class="row">               
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="inpa">
                                                <input type="radio" id="inpa" v-model="pat.patientstatus" value="1"> Inpatient
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="opd">
                                                <input type="radio" id="opd" v-model="pat.patientstatus" value="2"> OPD
                                            </label>
                                        </div>
                                    </div>                                    
                                </div>

                            </div>                            

                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input placeholder="Nationality" v-model="pat.nationality" id="nationality" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <input v-model="pat.religion" placeholder="Religion" id="religion" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input v-model="pat.occupation" placeholder="Occupation" id="occupation" type="text" class="validate form-control">                          
                            </div>
                        </div>
                        
                        <div class="col-sm-3">  
                            <div class="form-group">
                                <label for="fa">Father's Name</label>
                                <input placeholder="Father's Name" id="fa" v-model="pat.father_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="mom">Mother's Name</label>
                                <input placeholder="Mother's Name" id="mom" v-model="pat.mother_name" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input placeholder="Phone" required id="phone" v-model="pat.phone" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="fax">Fax</label>
                                <input placeholder="Fax" v-model="pat.fax" id="fax" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input placeholder="E-mail" v-model="pat.email" id="email" type="text" class="validate form-control">                          
                            </div>

                            <!-- <div class="form-group">
                                <label for="country">Country</label>
                                <input v-model="pat.country" placeholder="Country" id="country" type="text" class="validate form-control">                          
                            </div> -->
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea  class="validate form-control" placeholder="Address in details" id="address" v-model="pat.address" rows="3"></textarea>
                                <!-- <input v-model="pat.address" placeholder="Address" id="address" type="text" class="validate form-control">                           -->
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input v-model="pat.city" placeholder="City" id="city" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="State">
                                    <b-form-select v-model="pat.state_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in states" :value="item.id" :key="item.id">{{item.state_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea  class="validate form-control" placeholder="Remark in details" id="remark" v-model="pat.remark" rows="3"></textarea>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <!-- <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()"><i class="fa fa-save"></i> Save</label> -->
                    <!-- <label class="btn-primary btn" v-if="!savebtn" v-on:click="updatePat()">Edit</label> -->
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelPat()">Cancel</label>
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
      patId: null,
      pat: {
        patient_name: "",
        patient_reference: "",
        nrc: "",
        age: "",
        gender: 1,
        dob: new Date(),
        blood_type: "A",
        marital_status: "Single",
        city: "",
        country: "",
        nationality: "",
        address: "",
        religion: "",
        state_id: 0,
        father_name: "",
        mother_name: "",
        occupation: "",
        phone: "",
        fax: "",
        email: "",
        allergy: true,
        remark: "",
        patientstatus: 1
      },
      patients: [],
      states: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/patients", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.patients = response.data.patients;
        app.states = response.data.states;
      })
      .catch(error => {
        if (error.response.data.message == "Unauthenticated.") {
          localStorage.removeItem("token");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
          // this.$route.router.go('/');
        }
      });
  },
  methods: {
    customFormatter(date) {
      //return moment(date).format("DD/MM/YYYY");
      return moment(String(date)).format("MM-DD-YYYY");
    },
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/patients?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.patients = response.data.patients;
          // console.log(app.patients.length);
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

    newPat() {
      //document.body.classList.toggle("sidebar-minimized");

      // console.log(document.body.classList.length)
      // console.log(document.body.classList.toggle('sidebar-minimized'))
      // document.getElementsByTagName("body").classList.contains("sidebar-minimized");
      if (document.body.classList.length < 6) {
        //console.log("here");
        //document.getElementById("mytoggleclose").click();
        document.body.classList.toggle("sidebar-minimized");
      }

      this.cancelPat();
      this.showsetup = true;

      //   document.getElementById("testingid").classList.toggle("close");
      //   document.getElementsByTagName("body").addClass("sidebar-minimized");
      //  var root = document.documentElement;
      //  root.className += ' sidebar-minimized';
    },

    saveForm() {
      var app = this;
      var newPat = app.pat;
      axios
        .post("/api/patients", newPat, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("New Patient successfully saved.");
          app.patients = response.data.patients;
          app.states = response.data.states;
          app.cancelPat();
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

    editPat(id) {
      if (document.body.classList.length < 6) {
        document.body.classList.toggle("sidebar-minimized");
      }
      this.showsetup = true;
      var app = this;
      app.patId = id;
      app.savebtn = false;
      axios
        .get("/api/patients/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          //console.log(response.data);
          app.pat = response.data.patients;
          app.states = response.data.states;
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

    updatePat() {
      var app = this;
      var edpat = app.pat;
      // console.log("edpat" + edpat);
      // console.log("patid" + app.patId);
      axios
        .post("/api/patients/" + app.patId, edpat, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("Patient successfully Edited.");
          app.cancelPat();
          app.patients = response.data.patients;
          app.states = response.data.states;
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

    deletePat(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/patients/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.patients.data.splice(index, 1);
            alert("Patient successfully deleted.");
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

    cancelPat() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.pat.patient_name = "";
      app.pat.nrc = "";
      app.pat.gender = 1;
      app.pat.dob = new Date();
      app.pat.patient_reference = "";
      app.pat.address = "";
      app.pat.age = "";
      app.pat.blood_type = "A";
      app.pat.marital_status = "Single";
      app.pat.city = "";
      app.pat.country = "";
      app.pat.nationality = "";
      app.pat.religion = "";
      app.pat.father_name = "";
      app.pat.state_id = 0;
      app.pat.mother_name = "";
      app.pat.occupation = "";
      app.pat.phone = "";
      app.pat.fax = "";
      app.pat.email = "";
      app.pat.allergy = false;
      app.pat.remark = "";
      app.pat.patientstatus = 1;
    }
  }
};
</script>