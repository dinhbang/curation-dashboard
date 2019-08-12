<template>
    <div style="margin-top: 10px;width: 100%;">
        <div class="card">
            <div class="card-header">
                <strong>Rule Management</strong>
            </div>
            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-5">
                        <form v-on:submit="saveRule">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ID:</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" v-model="rule.id" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rule_name" v-model="rule.name"
                                           placeholder="Enter Rule name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description:</label>
                                <div class="col-sm-9">
                                    <textarea role="3" placeholder="Enter Rule description"
                                              class="form-control" v-model="rule.description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                    <div class="col-md-7">
                        <h4>Rules</h4>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="rule in rules">
                                <th scope="row">{{ rule.id}}</th>
                                <td>{{ rule.name}}</td>
                                <td>{{ rule.description}}</td>
                                <td>
                                    <button v-on:click="editRule(rule)" type="button" class="btn btn-success">Edit</button>
                                    <button v-on:click="delRule(rule)" type="button" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br/>

        <!-- Category -->
        <div class="card">
            <div class="card-header">
                <strong>Category Management</strong>
            </div>
            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-5">
                        <form>
                            <div class="form-row form-group">
                                <div class="col ">
                                    <select class="form-control" v-on:change="countryChange">
                                        <option>Choose Country</option>
                                        <option :selected="c.id==country.id" v-for="c in countries" v-bind:value="c.id">{{ c.name }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" v-on:keyup="onKeyUpCountry" v-model="country.name" class="form-control" placeholder="Country name">
                                </div>
                                <div class="col">
                                    <button type="button" v-if="isAdd.country" class="btn btn-success" v-on:click="addCountry">Add</button>
                                    <button type="button" v-if="country.id > 0 && country.name" class="btn btn-success" v-on:click="addCountry">Update</button>

                                    <button type="button" v-if="country.id > 0" class="btn btn-danger" v-on:click="delCountry">Delete</button>
                                </div>
                            </div>

                            <div class="form-row form-group">
                                <div class="col">
                                    <select class="form-control" v-on:change="typeChange">
                                        <option>Choose Type</option>
                                        <option :selected="t.id==type.id" v-for="t in types" v-bind:value="t.id" v-if="country.id > 0 && t.country_id == country.id">{{ t.name }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" v-on:keyup="onKeyUpType" v-model="type.name" class="form-control" placeholder="Type name">
                                </div>

                                <div class="col">
                                    <button type="button" v-if="isAdd.type" class="btn btn-success" v-on:click="addType">Add</button>
                                    <button type="button" v-if="type.id > 0 && type.name" class="btn btn-success" v-on:click="addType">Update</button>
                                    <button type="button" v-if="type.id > 0" class="btn btn-danger" v-on:click="delType">Delete</button>
                                </div>
                            </div>

                            <div class="form-row form-group">
                                <div class="col">
                                    <select class="form-control" v-on:change="categoryChange">
                                        <option>Choose Category</option>
                                        <option :selected="cat.id==category.id" v-for="cat in categories" v-bind:value="cat.id" v-if="type.id > 0 && cat.type_id == type.id">{{ cat.name }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" v-on:keyup="onKeyUpCategory" v-model="category.name" class="form-control" placeholder="Category name">
                                </div>

                                <div class="col">
                                    <button type="button" v-if="isAdd.category" class="btn btn-success" v-on:click="addCategory">Add</button>
                                    <button type="button" v-if="category.id > 0 && category.name" class="btn btn-success" v-on:click="updateCategory">Update</button>
                                    <button type="button" v-if="category.id > 0" class="btn btn-danger" v-on:click="delCategory">Delete</button>
                                </div>
                            </div>

                            <div class="form-row form-group">
                                <div class="col">
                                    <select class="form-control" v-on:change="ruleSelect">
                                        <option>Choose rule.</option>
                                        <option v-if="category && category.name" v-for="rule in rules" v-bind:value="rule.id">{{rule.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div style="margin-top: 20px">
                            <h4>Rules</h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Desc</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody v-if="category && category.name">
                                <tr v-for="rule in rulesAdded">
                                    <th scope="row">{{ rule.id}}</th>
                                    <td>{{ rule.name }}</td>
                                    <td>{{ rule.description }}</td>
                                    <td>
                                        <button type="button" v-on:click="delRulesAdded(rule)" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <button type="button" v-if="isSaveAll()" class="btn btn-success" v-on:click="addNewAll">Add New All</button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4>Categories</h4>
                        <table class="table">
                            <thead>
                            <tr>

                                <th scope="col">Country</th>
                                <th scope="col">Type</th>
                                <th scope="col">Category</th>
                                <th scope="col">Rules</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(category, idx) in categoryRules">

                                <td>{{ idx ==0 || category.country_name != categoryRules[idx-1].country_name ? category.country_name : '' }}</td>
                                <td>{{ idx ==0 || category.type_name != categoryRules[idx-1].type_name ? category.type_name : null }}</td>
                                <td>{{ idx ==0 || category.name != categoryRules[idx-1].name ? category.name : null }}</td>
                                <td>{{ category.rule_name }}</td>
                                <td>
                                    <button v-if="idx ==0 || category.name != categoryRules[idx-1].name" type="button" class="btn btn-success" v-on:click="editCategory(category)">Edit</button>
                                    <button v-if="idx ==0 || category.name != categoryRules[idx-1].name" type="button" class="btn btn-danger" v-on:click="delCategoryByRule(category)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <br />
    </div>
</template>

<script src="./CategoryRule.js"></script>
