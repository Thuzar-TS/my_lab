<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Items List <span class='badge badge-primary float-right add-btn' v-on:click='newIte()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
                    </div>
                    <div class="card-block">                        
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
                                <tr v-for="(ite,index) in items.data" :key="ite.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td>                                       
                                        
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{ite.description}}</a>&nbsp;
                                        
                                        <br>
                                        <span class="badge badge-success tbl-btn tbl-btn-success" style="letter-spacing: 1px;font-weight:bold;">
                                        {{ite.item_code}}
                                        </span>
                                        
                                        <span style="color:red;font-size:0.9em;">[ {{ite.short_description}} ]</span>
                                        <br>
                                       
                                        <span style="font-size:0.9em;font-weight:normal;">{{ite.group_name}} ({{ite.typedes}})</span><br> 
                                        <span style="font-size:0.9em;font-weight:normal;">{{ite.vendor_name}}</span> 
                                        <br><br>
                                        <a title="edit" v-on:click="editIte(ite.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteIte(ite.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>  <span v-if="ite.allergy==1" class="float-right" style="color:red;font-size:0.9em;">
                                        <i class="fa fa-check"></i> Allergy</span> 
                                        <span v-if="ite.allergy==0" class="float-right" style="color:#ccc;font-size:0.9em;">
                                        <i class="fa fa-close"></i> Allergy</span> 
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="fa fa-phone" style="color:blue;"></i> {{ite.phone}}<br>
                                        <i class="fa fa-home" style="color:blue;"></i> {{ite.address}}<br>
                                        <i class="fa fa-map-marker" style="color:blue;"></i> {{ite.city}}<br>
                                        <i class="fa fa-envelope" style="color:blue;"></i> {{ite.email}}<br>
                                        <i class="fa fa-print" style="color:blue;"></i> {{ite.fax}}
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="icon-user icons" style="font-size:0.9em;font-weight:bold;color:blue;"></i> {{ite.father_name}}<br>
                                        <i class="icon-user-female icons" style="font-size:0.9em;font-weight:bold;color:#f90bab;"></i> {{ite.mother_name}}<br><br>
                                        {{ite.nationality}}<br>
                                        {{ite.religion}}
                                    </td>
                                    <td>{{ite.remark}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="items" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>            
        </div>
        <div class="col-sm-10" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateIte()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>Item Setup <i v-on:click="cancelIte()" class="fa fa-close float-right closebtn"></i>
                </div>
               
                <div class="card-block">
                    <div class="row" v-if="ite.ismultilevel==1">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="item">Item Name</label>
                                <input placeholder="Item Name" required v-model="ite.description" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="item">Short Description</label>
                                <input required v-model="ite.short_description" placeholder="Short Description" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="item">Item Code</label>
                                <input placeholder="Code" required v-model="ite.item_code" type="text" class="validate form-control">                          
                            </div> 

                            <div class="form-group">
                                <b-form-fieldset label="Item Type">
                                    <b-form-select v-model="ite.item_type_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in itemtypes" :value="item.id" :key="item.id">{{item.description}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>                                

                        </div>

                        <div class="col-sm-3">                          

                            <div class="form-group">
                                <b-form-fieldset label="Group">
                                    <b-form-select v-model="ite.group_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in groups" :value="item.id" :key="item.id">{{item.group_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="Category">
                                    <b-form-select v-model="ite.category_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in categories" :value="item.id" :key="item.id">{{item.category_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="Brand">
                                    <b-form-select v-model="ite.brand_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in brands" :value="item.id" :key="item.id">{{item.brand_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div> 

                            <div class="form-group">
                                <b-form-fieldset label="Vendor">
                                    <b-form-select v-model="ite.lastvendor_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in vendors" :value="item.id" :key="item.id">{{item.vendor_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>                            
                        </div>

                        <div class="col-sm-3">                                                      

                            <div class="form-group" id="date">
                                <label for="dob">Expired Date</label>
                                <datepicker v-model="ite.expired_date" :format="customFormatter"></datepicker>
                            </div>

                            <div class="form-group" id="date">
                                <label for="dob">Last Purchase Date</label>
                                <datepicker v-model="ite.lastpurchase_date" :format="customFormatter"></datepicker>
                            </div>

                            <div class="form-group" id="date">
                                <label for="dob">Last Sale Date</label>
                                <datepicker v-model="ite.lastsale_date" :format="customFormatter"></datepicker>
                            </div>
                        </div>

                        <div class="col-sm-3">               
                        
                            <div class="form-group">
                                <label for="nationality">Sale Account</label>
                                <input placeholder="Account Number" v-model="ite.sale_account_number" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="religion">Purchase Account</label>
                                <input v-model="ite.purchase_account_number" placeholder="Account Number" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="occuiteion">Sale Return Account</label>
                                <input v-model="ite.salereturn_account_number" placeholder="Account Number" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="occuiteion">Purchase Return Account</label>
                                <input v-model="ite.purchasereturn_account_number" placeholder="Account Number" type="text" class="validate form-control">                          
                            </div>
                        </div>                        
                    </div>
                    <div class="row" v-if="ite.ismultilevel==false">
                        Hello
                    </div>
                    <div class="row bottom-clear">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="ite.inactive" style="cursor:pointer;">Inactive</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>                                                                                   
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1"  v-model="ite.ismultilevel" style="cursor:pointer;">Multi Level</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="ite.usebarcode" style="cursor:pointer;">Barcode</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div> 
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="ite.useexpire" style="cursor:pointer;">Expired</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelIte()">Cancel</label>
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
      iteId: null,
      ite: {
        item_code: "",
        description: "",
        short_description: "",
        item_type_id: 0,
        group_id: 0,
        expired_date: new Date(),
        lastpurchase_date: new Date(),
        lastsale_date: new Date(),
        category_id: 0,
        brand_id: 0,
        packing: "",
        lastvendor_id: 0,
        inactive: 1,
        ismultilevel: 1,
        usebarcode: 1,
        useexpire: 0,
        sale_account_number: "",
        purchase_account_number: "",
        salereturn_account_number: "",
        purchasereturn_account_number: "",
        img_path: ""
      },
      items: [],
      groups: [],
      categories: [],
      brands: [],
      vendors: [],
      itemtypes: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/items", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
          console.log(response.data);
        app.items = response.data.items;
        app.groups = response.data.groups;
        app.categories = response.data.categories;
        app.brands = response.data.brands;
        app.vendors = response.data.vendors;
        app.itemtypes = response.data.itemtypes;
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
    somefun(a){
        alert(a);
    },
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
        .get("/api/items?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.items = response.data.items;
          app.groups = response.data.groups;
          app.categories = response.data.categories;
          app.brands = response.data.brands;
          app.vendors = response.data.vendors;
          app.itemtypes = response.data.itemtypes;
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

    newIte() {  
      if (document.body.classList.length < 6) {  
        document.body.classList.toggle("sidebar-minimized");
      }

      this.cancelIte();
      this.showsetup = true;
    },

    saveForm() {
      var app = this;
      var newIte = app.ite;
      console.log(app.ite.inactive);
      console.log(app.ite.lastpurchase_date);
      axios
        .post("/api/items", newIte, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          //  console.log(response.data);
          alert("New item successfully saved.");
          app.items = response.data.items;
          app.groups = response.data.groups;
          app.categories = response.data.categories;
          app.brands = response.data.brands;
          app.vendors = response.data.vendors;
          app.itemtypes = response.data.itemtypes;
          app.cancelIte();
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

    editIte(id) {
      if (document.body.classList.length < 6) {
        document.body.classList.toggle("sidebar-minimized");
      }
      this.showsetup = true;
      var app = this;
      app.iteId = id;
      app.savebtn = false;
      axios
        .get("/api/items/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          //console.log(response.data);
          app.ite = response.data.items;
          app.groups = response.data.groups;
          app.categories = response.data.categories;
          app.brands = response.data.brands;
          app.vendors = response.data.vendors;
          app.itemtypes = response.data.itemtypes;
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

    updateIte() {
      var app = this;
      var edite = app.ite;
      // console.log("edite" + edite);
      // console.log("iteid" + app.iteId);
      axios
        .post("/api/items/" + app.iteId, edite, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("item successfully Edited.");
          app.cancelIte();
          app.items = response.data.items;
          app.groups = response.data.groups;
          app.categories = response.data.categories;
          app.brands = response.data.brands;
          app.vendors = response.data.vendors;
          app.itemtypes = response.data.itemtypes;
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

    deleteIte(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/items/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.items.data.splice(index, 1);
            alert("item successfully deleted.");
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

    cancelIte() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.ite.item_code = "";
      app.ite.description = "";
      app.ite.item_type_id = 0;
      app.ite.expired_date = new Date();
      app.ite.lastpurchase_date = new Date();
      app.ite.lastsale_date = new Date();
      app.ite.short_description = "";
      app.ite.group_id = 0;
      app.ite.category_id = 0;
      app.ite.brand_id = 0;
      app.ite.packing = "";
      app.ite.lastvendor_id = 0;
      app.ite.inactive = 0;
      app.ite.ismultilevel = 0;
      app.ite.usebarcode = 0;
      app.ite.useexpire = 0;
      app.ite.state_id = 0;
      app.ite.sale_account_number = "";
      app.ite.purchase_account_number = "";
      app.ite.salereturn_account_number = "";
      app.ite.purchasereturn_account_number = "";
      app.ite.img_path = "";
    }
  }
};
</script>