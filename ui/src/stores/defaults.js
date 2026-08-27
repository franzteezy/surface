export const sessionDomain = () => {
    let url = window.location.href.split('://');
    let domain = url[1].split('/')[0];
    let parts = domain.split('.');
    parts.shift();
    return parts.join('.');
};
const secure = () => {
    let url = window.location.href.split('://');
    return url[0] + '://';
};

export let actions = {
    get: (self, id, url_ext = '') => {
        return new Promise(function (resolve, reject) {
            window.mitt.emit('button_loading_trigger');
            self.loading = 'get';
            let source = axios.CancelToken.source();

            let url = secure() +  //                    https://
                (self.module ? self.module + '.' : '') + // authorize.
                sessionDomain() + //                        stafflify.test
                url_ext + //                                /forgot-password
                (id ? '/' + id : '/'); //                   /542dfsnionoadfs8345/ 


            if (window.running_processes['get_' + url]) {
                window.running_processes['get_' + url].cancel('cancelled - skipping')
            }
            window.running_processes['get_' + url] = source;
            window.axios.get(url, { cancelToken: source.token }).then(res => {
                const data = res.data !== undefined ? res.data : {};
                if (data.success) {
                    if (!!data.single) {
                        self.single = data.single; //assign data to single field
                    } else if (!!data.many) {
                        self.many = data.many; //assign data to many
                    }
                    window.mitt.emit('remove_button_loading');
                    window.mitt.emit('remove_button_loading');
                    self.loading = false;
                    delete window.running_processes['get_' + url];
                    resolve(data);
                } else {
                    window.notify(data.error.message, null, true);
                    window.mitt.emit('remove_button_loading');
                    self.loading = false;
                    delete window.running_processes['get_' + url];
                    reject(data.error);
                }
            }).catch(err => {
                window.mitt.emit('remove_button_loading');
                self.loading = false;
                delete window.running_processes['get_' + url];
                if (err.response?.data?.error?.message) {
                    window.notify(err.response.data.error.message, null, true, false, 0);
                }
                reject(err);
            })
        })
    },
    put: (self, url_ext = '') => {
        return new Promise(function (resolve, reject) {
            window.mitt.emit('button_loading_trigger');
            self.loading = 'put';
            let source = axios.CancelToken.source();
            let url = secure() + (self.module ? self.module + '.' : '') + sessionDomain() + '/put' + url_ext;
            if (window.running_processes['put_' + url]) {
                window.running_processes['put_' + url].cancel('cancelled - skipping')
            }
            window.running_processes['put_' + url] = source;
            window.axios.post(url, self.single, { cancelToken: source.token }).then(res => {
                const data = res.data !== undefined ? res.data : {};
                if (data.success) {
                    if (!!data.single) {
                        self.single = data.single; //assign data to single field
                    } else if (!!data.many) {
                        self.many = data.many; //assign data to many
                    }
                    window.mitt.emit('remove_button_loading');
                    delete window.running_processes['put_' + url];
                    self.loading = false;
                    resolve(data);
                } else {
                    window.notify(data.error.message, null, true, false, 0);
                    window.mitt.emit('remove_button_loading');
                    delete window.running_processes['put_' + url];
                    self.loading = false;
                    reject(data.error);
                }
            }).catch((err) => {
                window.mitt.emit('remove_button_loading');
                self.loading = false;
                delete window.running_processes['put_' + url];
                if (err.response?.data?.error?.message) {
                    window.notify(err.response.data.error.message, null, true, false, 0);
                }
                reject(err);
            })
        })
    },
    fetch: (self, postData, url_ext = '') => {

        window.mitt.emit('button_loading_trigger');
        return new Promise(function (resolve, reject) {
            self.loading = 'fetch';
            let source = axios.CancelToken.source();
            let url = secure() + (self.module ? self.module + '.' : '') + sessionDomain() + url_ext + '/';
            if (window.running_processes['fetch_' + url]) {
                for (let proc in window.running_processes['fetch_' + url]) {
                    window.running_processes['fetch_' + url][proc].cancel('cancelled - skipping')
                    delete window.running_processes['fetch_' + url][proc];
                }
            } else {
                window.running_processes['fetch_' + url] = [];
            }
            window.running_processes['fetch_' + url].push(source);
            let dataPack = postData ? { ...self.single, ...postData } : self.package;
            window.axios.post(url, dataPack, { cancelToken: source.token }).then(res => {
                const data = res.data !== undefined ? res.data : {};
                if (data.success === 'stream') {
                    self.many = [];
                    let running = 0;
                    for (let key in data.stream) {
                        running++;
                        let clonePack = JSON.parse(JSON.stringify(dataPack));
                        clonePack.stream_key = data.stream[key];
                        dataStream(clonePack, url).then(data => {
                            running--;
                            self.many = { ...self.many, ...data.many };
                            if (running === 0) {
                                window.mitt.emit('remove_button_loading');
                                self.loading = false;
                            }
                        });
                    }
                    resolve(data);
                } else if (data.success) {
                    if (!!data.single) {
                        self.single = data.single; //assign data to single field
                    } else if (!!data.many) {
                        self.many = data.many; //assign data to many
                    }
                    window.mitt.emit('remove_button_loading');
                    self.loading = false;
                    resolve(data);
                } else {
                    window.notify(data.error.message, null, true);
                    window.mitt.emit('remove_button_loading');
                    self.loading = false;
                    reject(data.error);
                }
            }).catch(err => {
                if (!axios.isCancel(err)) {
                    console.log('cancel', err);
                    window.mitt.emit('remove_button_loading');
                    self.loading = false;
                    console.log(err.response);
                    if (err.response?.data?.error?.message) {
                        window.notify(err.response.data.error.message, null, true, false, 0);
                    }
                }
                reject(err);
            })
        })
    },
    delete: {}
}

function dataStream(dataPack, stream) {
    return new Promise(function (resolve, reject) {
        window.axios.post(stream, dataPack).then(res => {
            const data = res.data !== undefined ? res.data : {};
            if (data.success) {
                if (data.success === 'stream') {
                    for (let key in data.stream) {
                        let clonePack = JSON.parse(JSON.stringify(dataPack));
                        clonePack.stream_key = data.stream[key];
                        dataStream(clonePack, stream).then(data => {
                            self.many = { ...self.many, ...data.many };
                        });
                    }
                }
                resolve(data);
            } else {
                reject(data.error);
            }
        })
    });
}