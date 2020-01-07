import React, {Component} from 'react';
import FileBrowser from './components/FileBrowser';
import getSocket, {EVENT_TYPES} from './misc/SocketConnection';
import ModalComponent from './components/ModalComponent';
import Editor from './components/Editor';

const NO_OP = () => {

};

const ROUTES = {
    LOADING: 'LOADING',
    FILE_BROWSER: 'FILE_BROWSER',
    EDITOR: 'EDITOR'
};

const COLORS = ["#660066", "#f6546a", "#088da5", "#003366", "#d0b38e", "#4b3624", "#482e04", "#d0a0ff", "#693278",
                "#3b6938", "#00ff80", "#088da5", "#c39527", "#eed78f", "#3b6938", "#f42a04", "#ff8e8e", "#ff0000",
                "#577ae4", "#008080", "#4169e1", "#088da5", "#ff3e50", "#003366", "#0080c0", "#80c000", "#c00080",
                "#00ff80", "#ff8000", "#8000ff", "#00ffff", "#ff00ff", "#0000ff"];

class App extends Component {
    constructor(props) {
        super(props);

        let name = localStorage.getItem('username');
        name = name ? name : 'Guest';

        this.state = {
            route: ROUTES.LOADING,
            newFile: false,
            newNotebookErr: '',
            user: {
                username: name
            },
            users: [],
            loadingText: 'Loading...'
        };

        this.onSelectNotebook = this.onSelectNotebook.bind(this);
        this.setRoute = this.setRoute.bind(this);
        this.showModal = this.showModal.bind(this);
        this.changeNewFile = this.changeNewFile.bind(this);
        this.onNewNotebook = this.onNewNotebook.bind(this);
        this.onDeleteNotebook = this.onDeleteNotebook.bind(this);
        this.getColor = this.getColor.bind(this);

        this.modalElement = null;
        this.editorElement = null;

        this.socketConnection = getSocket(name);

        this.listenEvents();

        this.socketConnection.loadAll((err, msg) => {
            if (err) {
                return console.log('Unsuccessful load all!', err);
            }

            console.log('loadAll', msg);

            let users = msg.data.usernameList.map(user => {
                return {
                    id: user.uniqueId,
                    username: user.username,
                    color: this.getColor(user.uniqueId)
                }
            });

            this.setState({
                user: {
                    username: this.state.user.username,
                    id: msg.data.yourIdentifier,
                    color: this.getColor(msg.data.yourIdentifier)
                },
                users: users
            }, () => {
                if (msg.data.openNotebook) {
                    this.setRoute(ROUTES.EDITOR, () => {
                        this.editorElement.loadNotebookLate(
                            msg.data.cellList,
                            msg.data.libraries,
                            msg.data.compilerFlags,
                            msg.data.lockedCellList,
                            msg.data.userLibraryList,
                            msg.data.lockedUserLibraries);
                    });
                } else {
                    this.setRoute(ROUTES.FILE_BROWSER);
                }
            });
        });
    }

    listenEvents() {
        this.socketConnection.onDisconnect(() => {
            this.setRoute(ROUTES.LOADING, () => {
                this.setState({
                    loadingText: 'Server unavailable'
                });
            });
        });

        this.socketConnection.registerListener([EVENT_TYPES.OPEN_NOTEBOOK_EVENT], (type, data) => {
            switch (type) {
                case EVENT_TYPES.OPEN_NOTEBOOK_EVENT:
                    this.setRoute(ROUTES.EDITOR, () => {
                        this.editorElement.loadNotebookLate(data.cellList,
                            data.libraries,
                            data.compilerFlags,
                            data.lockedCellList,
                            data.userLibraryList,
                            data.lockedUserLibraries);
                    });
                    break;
                default:
                    console.error('Case fallthrough, this should never happen');
            }
        });

        this.socketConnection.registerListener([EVENT_TYPES.USER_JOINED_EVENT,
            EVENT_TYPES.USER_LEFT_EVENT,
            EVENT_TYPES.USER_RENAME_EVENT], (type, data) => {

            let users;

            switch (type) {
                case EVENT_TYPES.USER_JOINED_EVENT:
                    users = this.state.users.slice();

                    users.push({
                        id: data.uniqueId,
                        username: data.username,
                        color: this.getColor(data.uniqueId)
                    });

                    this.setState({
                        users: users
                    });
                    break;
                case EVENT_TYPES.USER_LEFT_EVENT:
                    users = this.state.users.filter(user => user.id !== data.uniqueId);

                    this.setState({
                        users: users
                    });

                    console.log(type, data, users);
                    break;
                case EVENT_TYPES.USER_RENAME_EVENT:
                    users = this.state.users.slice();

                    let idx = users.findIndex(user => user.id === data.uniqueId);

                    if (idx !== -1) {
                        users[idx].username = data.username;
                    }

                    this.setState({
                        users: users
                    });

                    break;
                default:
                    console.error('Case fallthrough, this should never happen');
            }
        });
    }

    setRoute(route, callback = NO_OP) {
        if (!ROUTES.hasOwnProperty(route)) {
            return console.warn('Invalid route in setRoute()');
        }

        this.setState({
            route: route
        }, callback);
    }

    onSelectNotebook(path, callback) {
        this.socketConnection.openNotebook(path, (err, msg) => {
            if (err) {
                return callback(err);
            }

            this.setRoute(ROUTES.EDITOR, () => {
                this.editorElement.loadNotebook(msg.data.cells,
                    msg.data.libraries,
                    msg.data.compilerFlags,
                    msg.data.userLibraryList);
            });
            callback();
        })
    }

    onNewNotebook(path, name, callback) {
        this.socketConnection.createNotebook(path, name, (err, msg) => {
            if (err) {
                return callback(err);
            }

            this.setRoute(ROUTES.EDITOR, () => {
                this.editorElement.loadNotebook(msg.data.cells,
                    msg.data.libraries,
                    msg.data.compilerFlags,
                    msg.data.userLibraryList);
            });
            callback();
        });
    }

    onDeleteNotebook(path, callback) {
        this.socketConnection.deleteNotebook(path, callback);
    }

    changeNewFile() {
        if (this.state.newFile) {
            this.setState({newFile: false})
        } else {
            this.setState({newFile: true})
        }
    }

    showModal(title, message, callback) {
        this.modalElement.showModal(title, message, callback);
    }

    modalComponent() {
        return (
            <ModalComponent
                ref={modalRef => this.modalElement = modalRef}
                title=""
                message=""
            />
        );
    }

    fileBrowser() {
        return (
            <FileBrowser
                onSelectNotebook={this.onSelectNotebook}
                setRoute={this.setRoute}
                showModal={this.showModal}
                newFile={this.state.newFile}
                changeNewFile={this.changeNewFile}
                onNewNotebook={this.onNewNotebook}
                onDeleteNotebook={this.onDeleteNotebook}
                errorMsg={this.state.newNotebookErr}
                users={this.state.users}
                user={this.state.user}
            />
        );
    }

    editor() {
        return (
            <Editor
                ref={editorRef => this.editorElement = editorRef}
                setRoute={this.setRoute}
                showModal={this.showModal}
                changeNewFile={this.changeNewFile}
                user={this.state.user}
                users={this.state.users}
            />
        )
    }

    loading() {
        return (
            <div>
                <div className="loader" />
                <div className="loadingText">{this.state.loadingText}</div>
            </div>
        )
    }

    getColor(uniqueId) {
        return COLORS[parseInt(uniqueId.toString(), 16) % COLORS.length];
    }

    render() {
        let html;

        switch (this.state.route) {
            case ROUTES.EDITOR:
                html = this.editor();
                break;
            case ROUTES.FILE_BROWSER:
                html = this.fileBrowser();
                break;
            default:
                html = this.loading();
        }

        return (
            <div>
                {html}
                {this.modalComponent()}
            </div>
        );


    }
}

export default App;
export {App, ROUTES};
