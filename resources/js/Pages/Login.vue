<template>
    <div>
        <v-card elevation="2">
            <v-form v-model="valid">
                <v-container fluid class="content">
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="email"
                            :counter="10"
                            :rules="emailRules"
                            label="E-mail"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="password"
                            :counter="10"
                            :rules="passwordRules"
                            label="Password"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-btn
                        @click="login"
                        :loading="loading"
                        :disabled="!valid"
                        color="primary"
                        class="text-center btn"
                    >
                        Login
                    </v-btn>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    data: () => ({
        loading: false,
        valid: false,
        email: "",
        emailRules: [
            (value) => {
                if (value) return true;

                return "E-mail is required.";
            },
            (value) => {
                if (/.+@.+\..+/.test(value)) return true;

                return "E-mail must be valid.";
            },
        ],
        password: "",
        passwordRules: [
            (value) => {
                if (value) return true;

                return "Password is required.";
            },
            (value) => {
                if (value?.length <= 10) return true;

                return "Password must be less than 10 characters.";
            },
        ],
    }),
    computed: {
        ...mapState(["Auth"]),
    },
    methods: {
        ...mapActions("Auth", ["userLogin"]),
        async login() {
            try {
                this.loading = true;

                await this.userLogin({
                    email: this.email,
                    password: this.password,
                });
                this.$router.push({ name: "about" });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.content {
    display: flex;
    justify-self: center;
    align-items: center;
    flex-direction: column;
    .btn {
        padding: 10px 20px;
        height: 45px;
        cursor: pointer;
    }
}
</style>
