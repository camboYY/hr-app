<template>
    <div>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            <h3>Department List</h3>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table-server
                                v-model:items-per-page="departments.per_page"
                                :headers="headers"
                                :items="departments.data"
                                :loading="loading"
                                item-key="id"
                                @update:page="fetchDepartmentAgain"
                                :items-length="departments.total"
                            >
                                <template v-slot:loading>
                                    <v-skeleton-loader
                                        type="table-row@10"
                                    ></v-skeleton-loader>
                                </template>
                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <v-toolbar-title
                                            >Department List</v-toolbar-title
                                        >
                                        <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                        ></v-divider>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            @click="
                                                () =>
                                                    $router.push({
                                                        name: 'department.create',
                                                    })
                                            "
                                        >
                                            Add Department
                                        </v-btn>
                                    </v-toolbar>
                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <v-icon
                                        small
                                        class="mr-2"
                                        @click="onEditDepartment(item)"
                                    >
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon
                                        small
                                        @click="
                                            onConfirmDeleteDepartment(item.id)
                                        "
                                    >
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table-server>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <ConfirmationDialog
                :dialog="dialog"
                title="Confirmation"
                message="Are you sure wanted to delete this item?"
                :onConfirm="onDeleteDepartment"
                :onCancel="() => (dialog = false)"
            />
        </v-container>
    </div>
</template>

<script>
import ConfirmationDialog from "@/components/ConfirmationDialog.vue";
import { mapActions, mapGetters } from "vuex";
export default {
    data: () => ({
        loading: false,
        dialog: false,
        id: null,
        headers: [
            { title: "ID", key: "id" },
            { title: "Name", key: "name" },
            { title: "Description", key: "description" },
            { title: "Created At", key: "created_at" },
            {
                title: "Actions",
                key: "actions",
                sortable: false,
            },
        ],
    }),
    components: {
        ConfirmationDialog,
    },
    computed: {
        ...mapGetters("Department", ["departments"]),
    },
    async mounted() {
        await this.fetchDepartmentAgain();
    },
    methods: {
        ...mapActions("Department", [
            "fetchDepartments",
            "setDepartment",
            "deleteDepartment",
        ]),
        async fetchDepartmentAgain() {
            try {
                this.loading = true;
                await this.fetchDepartments();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        onEditDepartment(department) {
            this.setDepartment(department);
            this.$router.push({
                name: "department.edit",
                params: { id: department.id },
            });
        },
        onConfirmDeleteDepartment(id) {
            this.dialog = true;
            this.id = id;
        },

        async onDeleteDepartment() {
            this.dialog = false;
            await this.deleteDepartment(this.id);
        },
    },
};
</script>

<style lang="scss" scoped>
.title {
    color: #fff;
}
</style>
