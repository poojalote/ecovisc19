$(document).ready(function () {
	loadTree();

});

function loadTree()
{
	 $.LoadingOverlay("show");
	  $.ajax({
            type: "POST",
            url: baseURL+"loadTreeNodes",
            dataType: "json",
            data: '',
            success: function (result) {
                 $.LoadingOverlay("hide");
                if (result.status == 200) {
                    //console.log(manipulateTreeNodeData(result.data, result.type))
                    drowTree(manipulateTreeNodeData(result.data, result.type, result.selected));
                 
                   
                }
            }, error: function (error) {
                 $.LoadingOverlay("hide");
                console.log('Something went wrong please try again');
            }
        });
}

   function manipulateTreeNodeData(data, type, selected) {

        const indexMapping = data.reduce((array, item, index) => {
            array[item.id] = index;
            return array;
        }, {});

        let root;
        let cnt = 0;
        data.forEach(item => {

            if (type === 1) {

                if (item.type === item.id) {

                    root = item;
                    return;
                }
            } else {

                if (item.id === selected) {
                    root = item;

                    cnt = 1;
                    return;
                }
            }
            const parentEl = data[indexMapping[item.type]];

            if (parentEl) {
                parentEl.children = [...(parentEl.children || []), item];
            }
        });



        return root;

    }

      function drowTree(data) {

        var treePlugin = new d3.mitchTree.boxedTree()
            .setData(data)
            .setElement(document.getElementById("treebox"))
            .setIdAccessor(function (data) {
                return data.id;
            })
            .setChildrenAccessor(function (data) {
                // console.log(data);
                return data.children;
            })

            .setBodyDisplayTextAccessor(function (data) {
                // console.log(data);
                return data.description;
            })
            .setTitleDisplayTextAccessor(function (data) {
                //console.log(data);
                return data.name;
            }).on("nodeClick", function (event) {
                selectedNode = event.data;

                 document.getElementById('node_' + event.data.id).addEventListener('contextmenu', function (e) {
                    loadContextMenu(e, event.data)
                });
               
            })

            .initialize();
        treePlugin.update = function (nodeDataItem) {
            // Call the original update method
            this.__proto__.update.call(this, nodeDataItem);
            updateTreeClasses(this);
        }
        var nodes = treePlugin.getNodes();
        nodes.forEach(function (node, index, arr) {
            treePlugin.expand(node);
        });
        treePlugin.update(treePlugin.getRoot());
    }
function loadContextMenu(e, node,from=null) {
        let ids = node.patient_array;
      
        let items = [];

        //console.log(options);
         const downloadOptions = {
            type: 'item', title: 'Download Report', icon: 'fas fa-download', fn: function () {
                // $('.modal-backdrop.fade.in').remove();
                // $('.modal-backdrop.fade.show').remove();
                // $('#contract_modal').removeClass('in');
                // $('#contract_modal').removeClass('show');
                // $('#contract_modal_btn').click();
                // console.log(ids);
                if(ids!=null)
                {
                	if(ids.length>0)
	                {
	                	 downloadRiskReport(ids);
	                }
	                else
	                {
	                	app.errorToast('No Report Data Found');
	                }
                }
                else
                {
                	app.errorToast('No Report Data Found');
                }
                
               

            }
        }
        
         	items.push(downloadOptions);
     	
         basicContext.show(items, e);
    }

    function updateTreeClasses(treePlugin) {
        treePlugin.getPanningContainer().selectAll("g.node")
            .attr("class", function (data, index, arr) {
                var depthClass = "depth-" + data.depth;
                var existingClasses = this.getAttribute('class');
                this.setAttribute("id", "node_" + data.data.id);

                if (data.data.status == 1) {
                    this.children[0].children[0].classList.add("lightGreen")
                    this.children[1].children[0].classList.add("node-title")


                    //this.setAttribute("classList",data.data.id);
                } else if (data.data.status == 2) {
                    this.children[0].children[0].classList.add("darkGreen")
                    this.children[1].children[0].classList.add("node-title")
                }
                else if (data.data.status == 3) {
                    this.children[0].children[0].classList.add("lightRed")
                    this.children[1].children[0].classList.add("node-title")
                }
                else if (data.data.status == 4) {
                    this.children[0].children[0].classList.add("darkRed")
                    this.children[1].children[0].classList.add("node-title")
                }
                else if (data.data.status == 5) {
                    this.children[0].children[0].classList.add("extremRed")
                    this.children[1].children[0].classList.add("node-title")
                }
                if (data.data.comment > 0) {
                    let commentNode = `<path  d="M14.9,6.707c-0.804-2.497-3.649-4.351-7.035-4.351c-4.008,0-7.27,2.594-7.27,5.782 c0,2.163,1.516,4.133,3.903,5.122v3.091c0,0.251,0.144,0.478,0.372,0.586c0.087,0.042,0.182,0.062,0.276,0.062
 c0.148,0,0.295-0.051,0.412-0.15l3.678-3.038c0.14-0.022,0.275-0.057,0.413-0.084c0.655,0.666,1.544,1.185,2.607,1.46
 c0.198,0.051,0.401,0.094,0.608,0.125l2.641,2.182c0.118,0.099,0.264,0.15,0.413,0.15c0.094,0,0.188-0.02,0.276-0.062
 c0.228-0.108,0.372-0.335,0.372-0.586v-2.135c1.74-0.761,2.84-2.231,2.84-3.846C19.405,8.862,17.456,7.073,14.9,6.707z
 M8.885,12.552c-0.019,0.003-0.032,0.018-0.051,0.022c-0.101,0.022-0.2,0.056-0.281,0.123l-2.76,2.28v-2.161
 c0-0.275-0.175-0.521-0.434-0.612C3.253,11.467,1.89,9.871,1.89,8.138c0-2.474,2.68-4.487,5.975-4.487
 c2.604,0,4.801,1.265,5.617,3.014c0.187,0.401,0.302,0.823,0.33,1.268c0.005,0.069,0.028,0.134,0.028,0.205
 c0,1.819-1.481,3.438-3.706,4.129c-0.115,0.037-0.224,0.08-0.343,0.111C9.497,12.455,9.196,12.513,8.885,12.552z M15.703,13.809
 c-0.259,0.091-0.434,0.336-0.434,0.612v1.199l-1.723-1.422c-0.095-0.079-0.211-0.129-0.333-0.144
 c-0.219-0.028-0.431-0.068-0.636-0.121c-0.545-0.14-1.023-0.364-1.433-0.64c2.423-0.969,3.99-2.942,3.99-5.155
 c0-0.024-0.004-0.047-0.005-0.071c1.718,0.385,2.98,1.553,2.98,2.948C18.11,12.202,17.165,13.299,15.703,13.809z" transform="translate(170, -30)"></path>`;
                    this.children[0].insertAdjacentHTML('beforeend', commentNode);
                }


//                 if (data.data.dependencyNodeID !== 0) {
//                     let transform = `transform="translate(175, -30)"`;
//                     if (data.data.comment > 0) {
//                         transform = `transform="translate(145, -30)"`;
//                     }
//                     let linkNode = `<path  d="M19.175,4.856L15.138,0.82c-0.295-0.295-0.817-0.295-1.112,0L8.748,6.098c-0.307,0.307-0.307,0.805,0,1.112l1.462,1.462l-1.533,1.535L7.215,8.746c-0.307-0.307-0.805-0.307-1.112,0l-5.278,5.276c-0.307,0.307-0.307,0.805,0,1.112l4.037,4.037c0.154,0.153,0.355,0.23,0.556,0.23c0.201,0,0.403-0.077,0.556-0.23l5.28-5.276c0.148-0.148,0.23-0.347,0.23-0.556c0-0.209-0.083-0.409-0.23-0.556l-1.464-1.464l1.533-1.535l1.462,1.462c0.153,0.153,0.355,0.23,0.556,0.23c0.201,0,0.402-0.077,0.556-0.23l5.278-5.278c0.147-0.147,0.23-0.347,0.23-0.556C19.406,5.203,19.322,5.004,19.175,4.856zM9.585,13.339l-4.167,4.164l-2.925-2.925l4.166-4.164l0.906,0.905l-0.67,0.668c-0.307,0.307-0.307,0.805,0,1.112c0.154,0.153,0.356,0.23,0.556,0.23c0.203,0,0.403-0.077,0.556-0.23l0.67-0.668L9.585,13.339z M13.341,9.578l-0.906-0.906l0.663-0.662c0.307-0.307,0.307-0.805,0-1.112c-0.307-0.307-0.805-0.307-1.112,0L11.322,7.56l-0.906-0.906l4.166-4.166l2.925,2.925L13.341,9.578z"
//                         ${transform}>
// <title>${data.data.depndencyNodeName}</title>
// </path>`;
//                     this.children[0].insertAdjacentHTML('beforeend', linkNode);
//                 }

                if (data.data.assignToMe) {
                    let transform = `transform="translate(175, -30)"`;
                    if (data.data.comment > 0) {
                        if (data.data.dependencyNodeID !== 0) {
                            transform = `transform="translate(115, -30)"`;
                        } else {
                            transform = `transform="translate(145, -30)"`;
                        }
                    } else {
                        if (data.data.dependencyNodeID !== 0) {
                            transform = `transform="translate(145, -30)"`;
                        }
                    }
                    let mynode = `<path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z" ${transform} style="stroke: red;" ></path>`;
                    this.children[0].insertAdjacentHTML('beforeend', mynode);
                }
                if (!existingClasses)
                    return depthClass;
                var hasDepthClassAlready = (' ' + existingClasses + ' ').indexOf(' ' + depthClass + ' ') > -1;
                if (hasDepthClassAlready)
                    return existingClasses;
                return existingClasses + " " + depthClass;
            });
    }

    function downloadRiskReport(ids)
    {

		var loginFormObject = {};
		loginFormObject["ids"]=ids;
		const x=JSON.stringify(loginFormObject);
		window.location.href= baseURL+"getRiskExcelReport?data=" + x;
    }