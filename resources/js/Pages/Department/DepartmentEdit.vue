<template>
    <div>
        <v-container>
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <h2>Edit Department</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="editDept">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        label="Name"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="description"
                                        label="Description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn
                                        :loading="loading"
                                        color="primary"
                                        type="submit"
                                    >
                                        Update
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-container>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    data: () => ({
        loading: false,
        name: "",
        nameRules: [
            (value) => {
                if (value) return true;

                return "Name is required.";
            },
            (value) => {
                const regex = /^[a-zA-Z ]+$/;
                if (regex.test(value)) return true;

                return "Name must alphabets only.";
            },
        ],
        description: "",
    }),
    computed: {
        ...mapGetters("Department", ["department"]),
    },
    methods: {
        ...mapActions("Department", ["editDepartment", "fetchDepartment"]),
        async editDept() {
            try {
                this.loading = true;
                await this.editDepartment({
                    ...this.department,
                    name: this.name,
                    description: this.description,
                });

                this.$router.push({ name: "department.list" });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
    },
    async created() {
        const department = await this.fetchDepartment(this.$route.params.id);
        this.name = department.name;
        this.description = department.description;
    },
};
</script>

<style lang="scss" scoped>
.flex {
    display: flex;
    flex-direction: column;
    gap: 10px;
    button {
        height: 46px;
        width: 20%;
        margin: 0 auto;
    }
}
</style>
