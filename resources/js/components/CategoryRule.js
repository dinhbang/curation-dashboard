import axios from 'axios'
import _ from 'lodash'

import Vue from 'vue';


export default {
    props: {},
    components: {},
    mounted() {
        this.initData([]);
    },
    data() {
        return {
            countries: [],
            types: [],
            categories: [],
            rules: [],
            categoryRules: [],
            rulesAdded: [],
            isAdd: {country: false, type: false, category: false},
            country: {id: null, name: null},
            type: {id: null, name: null, country_id: null},
            category: {id: null, name: null, type_id: null, rules: []},
            rule: {id: null, name: null, description: null},
            modelKeyUp: null
        }
    },
    methods: {
        initData: function (included = []) {
            const obj = this;
            this.getData(allData, included, function (res) {
                obj.countries = res.data.countries;
                obj.types = res.data.types;
                obj.categories = res.data.categories;
                obj.rules = res.data.rules;
                obj.categoryRules = res.data.categoryRules;
            });
        },

        initDataCategoryRule: function (included = []) {
            const obj = this;
            this.getData(allData, included, function (res) {
                obj.categories = res.data.categories;
                obj.rules = res.data.rules;
                obj.categoryRules = res.data.categoryRules;
            });
        },

        saveRule: function (e) {
            const obj = this;
            e.preventDefault();
            if (this.rule.name == null) {
                return false;
            }
            let index = -1;
            if (this.rule.id > 0) {
                index = this.rules.indexOf(this.rule);
                if (index) {
                    this.rules[index] = this.rule;
                    this.postData(_.replace(ruleUpdate, '123456789', this.rule.id), this.rule, function (res) {
                        obj.initData();
                    });
                }
            } else {
                if (this.rules) {
                    index = this.rules.indexOf(this.rule);
                }
                if (index == -1) {
                    this.postData(ruleStore, this.rule, function (res) {
                        obj.initData();
                    });
                }
            }
            this.rule = {id: 0, name: null, description: null};
        },

        editRule: function (ruling) {
            console.log(ruling);
            this.rule = _.clone(ruling);
        },

        delRule: function (ruling) {
            console.log(ruling);
            const obj = this;
            Vue.dialog
                .confirm(`Are you sure you want to delete '${ruling.name}' ID#${ruling.id}?`)
                .then(function (dialog) {
                    obj.rules.splice(obj.rules.indexOf(ruling), 1);
                    obj.deleteData(_.replace(ruleDelete, '123456789', ruling.id), ruling, function (res) {
                        console.log(res);
                        obj.initData();
                    })
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });
        },

        ruleChange: function (e) {
            const index = _.findIndex(this.types, function (o) {
                return o.id == e.target.value;
            });
            if (index >= 0) {
                this.type = _.clone(this.types[index]);
            }
        },

        ruleSelect: function (e) {
            const obj = this;
            let index = _.findIndex(this.rulesAdded, function (o) {
                return o.id == e.target.value;
            });
            if (index < 0) {
                index = _.findIndex(this.rules, function (o) {
                    return o.id == e.target.value;
                });
                this.rulesAdded.push(this.rules[index]);

                if(this.category.id > 0) {
                    this.postData(storeRule, {
                        category_id: this.category.id,
                        rule_id: e.target.value
                    }, function (res) {
                        obj.initData([]);
                    });
                }
            }
        },

        countryChange: function (e) {
            console.log(e.target.value)
            const index = _.findIndex(this.countries, function (o) {
                return o.id == e.target.value;
            });
            if (index >= 0) {
                this.country = _.clone(this.countries[index]);
            } else {
                this.country = {};
            }
            this.type = {};
            this.isAdd.type = false;
            this.category = {};
            this.isAdd.category = false;
            this.isAdd.country = false;
            this.rulesAdded = []
        },

        typeChange: function (e) {
            const index = _.findIndex(this.types, function (o) {
                return o.id == e.target.value;
            });
            if (index >= 0) {
                this.type = _.clone(this.types[index]);
            } else {
                this.type = {};
            }
            this.isAdd.type = false;
            this.category = {};
            this.isAdd.category = false;
            this.rulesAdded = []
        },

        categoryChange: function (e) {
            const index = _.findIndex(this.categories, function (o) {
                return o.id == e.target.value;
            });
            if (index >= 0) {
                this.category = _.clone(this.categories[index]);
            } else {
                this.category = {};
            }
            this.isAdd.category = false;
            this.rulesAdded = []
        },

        addCountry: function () {
            const obj = this;
            if (this.country) {
                if (this.country.id > 0) {
                    this.postData(_.replace(countryUpdate, '123456789', this.country.id), this.country, function (res) {
                        obj.initData();
                    })
                } else {
                    this.postData(countryStore, this.country, function (res) {
                        obj.initData();
                    })
                    this.country = {id: null, name: null};
                    this.isAdd.country = false;
                }
            }

        },

        delCountry: function () {
            const obj = this;
            Vue.dialog
                .confirm(`Are you sure you want to delete '${obj.country.name}' ID#${obj.country.id}?`)
                .then(function (dialog) {
                    console.log(obj.country, dialog);
                    obj.countries.splice(obj.countries.indexOf(obj.country), 1);
                    obj.deleteData(_.replace(countryDelete, '123456789', obj.country.id), {}, function (res) {
                        obj.country = {id: null, name: null};
                        obj.initData();
                    })
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });

        },

        addType: function () {
            const obj = this;
            if (this.type && this.country) {
                this.type.country_id = this.country.id;
                if (this.type.id > 0) {
                    this.postData(_.replace(typeUpdate, '123456789', this.type.id), this.type, function (res) {
                        obj.initData();
                    })
                } else {
                    this.postData(typeStore, this.type, function (res) {
                        obj.initData();
                    })
                    this.type = {};
                    this.isAdd.type = false;
                }
            }

        },

        delType: function () {
            const obj = this;
            console.log(this.type);

            Vue.dialog
                .confirm(`Are you sure you want to delete '${obj.type.name}' ID#${obj.type.id}?`)
                .then(function (dialog) {
                    obj.types.splice(this.types.indexOf(obj.type), 1);
                    obj.deleteData(_.replace(typeDelete, '123456789', obj.type.id), {}, function (res) {
                        obj.type = {};
                        obj.initData();
                    })
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });
        },

        addCategory: function () {
            const obj = this;
            if (this.category && this.type) {
                this.category.type_id = this.type.id;
                this.category.rules = this.rulesAdded;

                if (this.category.id > 0) {
                    this.postData(_.replace(categoryUpdate, '123456789', this.category.id), this.category, function (res) {
                        obj.initData();
                    })
                } else {
                    this.postData(categoryStore, this.category, function (res) {
                        obj.initData();
                    })
                    this.category = {};
                    this.isAdd.category = false;
                }
            }

        },

        updateCategory: function () {
            this.addCategory();
        },

        editCategory: function (category) {
            console.log(category);
            let index = _.findIndex(this.countries, function (o) {
                return o.id == category.country_id;
            });
            this.country = _.clone(this.countries[index]);

            index = _.findIndex(this.types, function (o) {
                return o.id == category.type_id;
            });
            this.type = _.clone(this.types[index]);

            index = _.findIndex(this.categories, function (o) {
                return o.id == category.id;
            });
            this.category = _.clone(this.categories[index]);

            //get rules
            this.getCategoryRules(category);
            this.isAdd.category = false;
        },

        delCategory: function () {
            const obj = this;
            console.log('delCategory',this.category);

            Vue.dialog
                .confirm(`Are you sure you want to delete '${obj.category.name}' ID#${obj.category.id}?`)
                .then(function (dialog) {
                    let index = _.findIndex(obj.categories, function (o) {
                        return o.id == obj.category.id;
                    });
                    obj.categories.splice(index, 1);

                    index = _.findIndex(obj.categoryRules, function (o) {
                        return o.id == obj.category.id;
                    });
                    obj.categoryRules.splice(index, 1);

                    obj.deleteData(_.replace(categoryDelete, '123456789', obj.category.id), {}, function (res) {
                        obj.category = {};
                        obj.initData();
                    });
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });
        },

        delCategoryByRule: function (category) {
            console.log('delCategoryByRule',category);
            const obj = this;

            Vue.dialog
                .confirm(`Are you sure you want to delete '${category.name}' ID#${category.id}?`)
                .then(function (dialog) {
                    let index = _.findIndex(obj.categories, function (o) {
                        return o.id == category.id;
                    });
                    obj.categories.splice(index, 1);

                    index = _.findIndex(obj.categoryRules, function (o) {
                        return o.id == category.id;
                    });
                    obj.categoryRules.splice(index, 1);

                    obj.deleteData(_.replace(categoryDelete, '123456789', category.id), {}, function (res) {
                        obj.category = {};
                        obj.initData();
                    });
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });
        },

        getCategoryRules: function (category) {
            const categories = _.filter(this.categoryRules, function (o) {
                return o.id == category.id && o.country_id == category.country_id && o.type_id == category.type_id;
            });

            if (!_.isEmpty(categories)) {
                const ruleIds = _.map(categories, 'rule_id');
                console.log(ruleIds);
                this.rulesAdded = _.filter(this.rules, function (o) {
                    return ruleIds.indexOf(o.id) > -1;
                });
            }
        },

        delRulesAdded: function (rule) {
            const obj = this;
            console.log(rule);

            Vue.dialog
                .confirm(`Are you sure you want to delete '${rule.name}' ID#${rule.id}?`)
                .then(function (dialog) {
                    obj.rulesAdded.splice(obj.rulesAdded.indexOf(rule), 1);

                    obj.postData(_.replace(deleteRule, '123456789', rule.id), {}, function (res) {
                        obj.initData([]);
                    });
                })
                .catch(function () {
                    console.log('Clicked on cancel');
                });
        },

        onKeyUpCountry: function (e) {
            this.modelKeyUp = 'country';
            this.onKeyUp(e);
        },

        onKeyUpType: function (e) {
            if (this.country.id) {
                this.modelKeyUp = 'type';
                this.onKeyUp(e);
            }
        },

        onKeyUpCategory: function (e) {
            if (this.type.id) {
                this.modelKeyUp = 'category';
                this.onKeyUp(e);
            }
        },

        onKeyUp: function (e) {
            let index = -1;
            switch (this.modelKeyUp) {
                case 'country':
                    if (!e.target.value || this.country.id) {
                        this.isAdd.country = false;
                    } else {
                        index = _.findIndex(this.countries, function (o) {
                            return o.name == e.target.value;
                        });
                        if (index >= 0) {
                            this.isAdd.country = false;
                        } else {
                            this.isAdd.country = true;
                        }
                    }
                    break;

                case 'type':
                    if (!e.target.value || this.type.id) {
                        this.isAdd.type = false;
                        return;
                    }

                    index = _.findIndex(this.types, function (o) {
                        return o.name == e.target.value;
                    });
                    if (index >= 0) {
                        this.isAdd.type = false;
                    } else {
                        this.isAdd.type = true;
                    }
                    break;

                case 'category':
                    if (!e.target.value || this.category.id) {
                        this.isAdd.category = false;
                        return;
                    }

                    index = _.findIndex(this.categories, function (o) {
                        return o.name == e.target.value;
                    });
                    if (index >= 0) {
                        this.isAdd.category = false;
                    } else {
                        this.isAdd.category = true;
                    }
                    break;
            }
        },

        isSaveAll: function () {
            /*const obj = this;
            if(!this.type.name || !this.category.name) {
                return  false;
            }

            let index = -1;
            index = _.findIndex(this.types, function (o) {
                return o.name == obj.type.name;
            });

            if(index > -1) {
                return  false;
            }

            index = _.findIndex(this.categories, function (o) {
                return o.name == obj.category.name;
            });

            if(index > -1) {
                return  false;
            }*/

            return !(this.country.id) && this.country.name && !(this.type.id) && this.type.name && !this.category.id && this.category.name;
        },

        addNewAll: function () {
            const obj = this;
            const ruleIds = _.map(obj.rulesAdded, 'id');
            console.log(ruleIds);
            obj.postData(storeAll, {
                country_name: obj.country.name,
                type_name: obj.type.name,
                category_name: obj.category.name,
                rules: ruleIds
            }, function (res) {
                obj.initData([]);
            });
        },

        getData: function (action, data, callback) {
            axios.get(action, data)
                .then((res) => {
                    console.log(res);
                    if(callback) {
                        callback(res);
                    }
                })
        },

        postData: function (action, data, callback) {
            axios.post(action, data)
                .then((res) => {
                    console.log(res);
                    if(callback) {
                        callback(res);
                    }
                })
        },

        deleteData: function (action, data, callback) {
            axios.post(action, data)
                .then((res) => {
                    console.log(res);

                    if(callback) {
                        callback(res);
                    }
                })
        }
    }
}
