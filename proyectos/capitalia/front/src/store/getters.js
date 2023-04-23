const getters = {
    isLoggedIn: state => !!state.auth.token,
    getUser: state => state.auth.user,
    getToken: state => state.auth.token,
    getLoading: state => state.auth.loading,
    getListData: state => state.auth.list_data
};

export default getters