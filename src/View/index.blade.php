<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>

    <link href="/vendor/apidoc/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .text-limegreen {color: limegreen;}/*字符串的样式*/
        .text-darkorange {color: darkorange;}/*数字的样式*/
        .text-orange { color: orange;}/*布尔型数据的样式*/
        .text-magenta { color: magenta;}/*null值的样式*/
    </style>
</head>
<body>
<div class="container-fluid px-0">
    <div class="row mx-0">
        <nav class="col-2 bg-light px-0 position-fixed">
            <div class="sidebar-sticky px-3 pt-3 position-relative overflow-auto" style="height: calc(100vh);">
                @foreach($groups as $group)
                    <div class="group px-2 mb-4">
                        <h5 class="bg-white p-2 mb-0"><a href="#{{ $group }}" class="text-decoration-none text-muted">{{ $group }}</a></h5>
                        <ul class="nav flex-column">
                            @foreach($datas as $data)
                                @if($data['apiGroup'] === $group)
                                    <li class="nav-item px-2 py-1"><a href="#{{ $data['apiName'] }}" class="text-decoration-none text-dark">{{ $data['apiTitle'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>

        <main role="main" class="col-10 ml-auto px-5">
            <div class="header mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2">
                    <h1>{{ $name }}</h1>
{{--                    <div class="btn-toolbar mb-2 mb-md-0">--}}
{{--                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"><span data-feather="calendar"></span>This week</button>--}}
{{--                    </div>--}}
                </div>
                <h3>{!! $description !!}</h3>
            </div>

            <div class="section">
                @foreach($groups as $group)
                    <div id="{{ $group }}" class="mb-4 pb-3 border-bottom">
                        <h1 class="mb-2"><b>{{ $group }}</b></h1>
                        @foreach($datas as $data)
                            @if($data['apiGroup'] === $group)
                                <div id="{{ $data['apiName'] }}" class="py-4">
                                    <h4><b>{{ $group }} - {{ $data['apiTitle'] }}</b></h4>

                                    <h6 class="text-secondary mb-3">{!! $data['apiDescription'] !!}</h6>

                                    <div class="bg-dark text-white py-2 mb-3 rounded border-0">
                                        <span class="bg-primary p-2 rounded mr-3"><b>{{ $data['apiType'] }}</b></span>
                                        <span>{{ $data['apiUrl'] }}</span>
                                    </div>

                                    @if($data['apiHeaders'])
                                        <h4><b class="lang-header"></b></h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-light">
                                                <th scope="col" class="lang-field"></th>
                                                <th scope="col" class="lang-type"></th>
                                                <th scope="col" class="lang-description"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data['apiHeaders'] as $header)
                                                <tr>
                                                    <td style="width: 300px;">
                                                        {{ $header['field'] }}
                                                        @if($header['optional'])
                                                            <span class="bg-secondary text-white rounded px-2 float-right lang-optional"></span>
                                                        @endif

                                                    </td>
                                                    <td style="width: 300px;">{{ $header['type'] }}</td>
                                                    <td>{{ $header['description'] }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    @if($data['apiParams'])
                                        <h4><b class="lang-form"></b></h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="bg-light">
                                                <th scope="col" class="lang-field"></th>
                                                <th scope="col" class="lang-type"></th>
                                                <th scope="col" class="lang-description"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data['apiParams'] as $params)
                                                <tr>
                                                    <td style="width: 300px;">
                                                        {{ $params['field'] }}
                                                        @if($params['optional'])
                                                            <span class="bg-secondary text-white rounded px-2 float-right lang-optional"></span>
                                                        @endif
                                                    </td>
                                                    <td style="width: 300px;">{{ $params['type'] }}</td>
                                                    <td>{{ $params['description'] }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    @if(isset($data['apiHeaderExample']))
                                        <nav>
                                            <div class="nav nav-tabs">
                                                <a class="nav-item nav-link active">{{ $data['apiHeaderExample'][0] }}</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active">
                                                <p class="bg-dark text-white pl-1 rounded json" style="white-space: pre;">
                                                    {{ $data['apiHeaderExample'][1] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($data['apiParamExample']))
                                        <nav>
                                            <div class="nav nav-tabs">
                                                <a class="nav-item nav-link active">{{ $data['apiParamExample'][0] }}</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active">
                                                <p class="bg-dark text-white pl-1 rounded json" style="white-space: pre;">
                                                    {{ $data['apiParamExample'][1] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($data['apiSuccessExample']))
                                        <nav>
                                            <div class="nav nav-tabs">
                                                <a class="nav-item nav-link active">{{ $data['apiSuccessExample'][0] }}</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active">
                                                <p class="bg-dark text-white pl-1 rounded json" style="white-space: pre;">
                                                    {{ $data['apiSuccessExample'][1] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($data['apiErrorExample']))
                                        <nav>
                                            <div class="nav nav-tabs">
                                                <a class="nav-item nav-link active">{{ $data['apiErrorExample'][0] }}</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active">
                                                <p class="bg-dark text-white pl-1 rounded json" style="white-space: pre;">
                                                    {{ $data['apiErrorExample'][1] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    <h4 class="mb-3"><b class="lang-send-examples-request"></b></h4>
                                    <form id="form-{{ $data['apiName'] }}">
                                        <div class="form-group row mx-0">
                                            @if($data['apiHeaders'])
                                                <h6><b class="lang-header-param"></b></h6>
                                                @foreach($data['apiHeaders'] as $headers)
                                                    @if($headers['type'] === 'string')
                                                        <div class="input-group mb-3">
                                                            <label for="header-{{ $data['apiName'] }}-{{ $headers['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $headers['field'] }}</label>
                                                            <input type="text" name="headers[{{ $headers['field'] }}]" class="col-sm-10 form-control" id="header-{{ $data['apiName'] }}-{{ $headers['field'] }}" placeholder="{{ $headers['field'] }}">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">{{ $headers['type'] }}</div>
                                                            </div>
                                                        </div>
                                                    @elseif($headers['type'] === 'int')
                                                        <div class="input-group mb-3">
                                                            <label for="header-{{ $data['apiName'] }}-{{ $headers['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $headers['field'] }}</label>
                                                            <input type="number" name="headers[{{ $headers['field'] }}]" class="col-sm-10 form-control" id="header-{{ $data['apiName'] }}-{{ $headers['field'] }}" placeholder="{{ $headers['field'] }}">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">{{ $headers['type'] }}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                            @if($data['apiParams'])
                                                <h6><b class="lang-form-param"></b></h6>
                                                @foreach($data['apiParams'] as $params)
                                                    @if($params['type'] === 'string')
                                                            <div class="input-group mb-3">
                                                                <label for="params-{{ $data['apiName'] }}-{{ $params['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                                <input type="text" name="{{ $params['field'] }}" class="col-sm-10 form-control" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}" placeholder="{{ $params['field'] }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ $params['type'] }}</div>
                                                                </div>
                                                            </div>
                                                    @elseif($params['type'] === 'int')
                                                            <div class="input-group mb-3">
                                                                <label for="params-{{ $data['apiName'] }}-{{ $params['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                                <input type="number" name="{{ $params['field'] }}" class="col-sm-10 form-control" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}" placeholder="{{ $params['field'] }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ $params['type'] }}</div>
                                                                </div>
                                                            </div>
                                                    @elseif($params['type'] === 'bool')
                                                            <div class="input-group mb-3">
                                                                <label class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                                <div class="align-self-center">
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" name="{{ $params['field'] }}" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}1" value="true" class="custom-control-input">
                                                                        <label class="custom-control-label" for="params-{{ $data['apiName'] }}-{{ $params['field'] }}1">true</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" name="{{ $params['field'] }}" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}2" value="false" class="custom-control-input">
                                                                        <label class="custom-control-label" for="params-{{ $data['apiName'] }}-{{ $params['field'] }}2">false</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group-text">{{ $params['type'] }}</div>
                                                            </div>
                                                    @elseif($params['type'] === 'json')
                                                            <div class="input-group mb-3">
                                                                <label for="params-{{ $data['apiName'] }}-{{ $params['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                                <textarea name="{{ $params['field'] }}" class="form-control" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}" placeholder="{{ $params['field'] }}"></textarea>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ $params['type'] }}</div>
                                                                </div>
                                                            </div>
                                                    @elseif($params['type'] === 'select')
                                                        <div class="input-group mb-3">
                                                            <label for="params-{{ $data['apiName'] }}-{{ $params['field'] }}" class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                            <select class="custom-select" name="{{ $params['field'] }}" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}">
                                                                <option value="">Choose...</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">{{ $params['type'] }}</div>
                                                            </div>
                                                        </div>
                                                    @elseif($params['type'] === 'file')
                                                            <div class="input-group mb-3">
                                                                <label class="col-sm-2 px-0 col-form-label">{{ $params['field'] }}</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="{{ $params['field'] }}" class="custom-file-input" id="params-{{ $data['apiName'] }}-{{ $params['field'] }}">
                                                                    <label class="custom-file-label" for="validatedCustomFile">{{ $params['field'] }}</label>
                                                                </div>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ $params['type'] }}</div>
                                                                </div>
                                                            </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </form>
                                    <p class="text-right">
                                        <a class="btn btn-primary submit lang-send-request" href="javascript:void(0)" data-method="{{ $data['apiType'] }}" data-url="{{ $data['apiUrl'] }}" data-name="{{ $data['apiName'] }}"></a>
                                    </p>
                                    <div class="collapse" id="collapse-{{ $data['apiName'] }}">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="lang-return-result"></span>
                                            <a class="btn btn-xs btn-dark text-white px-1 py-0 closes" href="javascript:void(0)" data-name="{{ $data['apiName'] }}">X</a>
                                        </div>

                                        <div class="bg-dark text-white rounded result" style="white-space: pre;"></div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                @endforeach
            </div>
        </main>
    </div>
</div>
<script src="/vendor/apidoc/js/jquery-3.5.1.min.js"></script>
<script src="/vendor/apidoc/js/popper.min.js"></script>
<script src="/vendor/apidoc/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // 设置语言
        let lang = $('html').attr('lang');
        $.each(JSON.parse('{!! json_encode($local, true) !!}'), function (key, val) {
            $.each(val,function (k, v) {
                $('.lang-' + k).text(lang === key ? v : k);
            })
        });
        // 关闭返回结果操作
        $('.closes').click(function () {
            let name = $(this).data('name');
            $('#collapse-' + name).collapse('hide');
        });
        // 发送请求操作
        $('.submit').click(function () {
            let method = $(this).data('method');
            let url = $(this).data('url');
            let name = $(this).data('name');
            let files = $("#form-" + name + " input[type='file']");

            let data = new FormData(document.getElementById("form-" + name));

            let headers = {};
            let params = {};
            let delete_key = [];
            for (let key of data.keys()) {
                // console.dir("key:" + key + " value:" + data.get(key));
                if (key.indexOf("headers") !== -1) {
                    let field = key.substring(7).replace(/\[|]/g,'');
                    headers[field] = data.get(key);
                    delete_key.push(key);
                } else {
                    if (files.length <= 0) {
                        params[key] = data.get(key);
                    } else {
                        params = data;
                    }
                }
            }

            $.each(delete_key, function (key, val) {
                data.delete(val);
            });

            let ajaxRequest = {
                url: url,
                type: method,
                headers: headers,
                data: params,
                success:function (res) {
                    $('#collapse-' + name + ' .result').html(syntaxHighlight(JSON.stringify(res)));
                    $('#collapse-' + name).collapse('show');
                },
                error: function (res) {
                    $('#collapse-' + name + ' .result').html(syntaxHighlight(JSON.stringify(res.responseJSON)));
                    $('#collapse-' + name).collapse('show');
                }
            };

            if (files.length > 0) {
                ajaxRequest.processData = false;
                ajaxRequest.contentType = false;
            }

            $.ajax(ajaxRequest);
        });
        // 载入示例
        $.each($('.json'),function () {
            let json = $(this).text();
            $(this).html(syntaxHighlight(json));
        });
    });

    /**
     * Json 语法高亮
     *
     * @param json
     * @returns {string}
     */
    function syntaxHighlight(json) {
        json = JSON.stringify(JSON.parse(json), null, "\t");

        return json.replace(/<br>/g, ' ').replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
            function(match) {
                let cls = 'text-darkorange';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'text-white';
                    } else {
                        cls = 'text-limegreen';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'text-orange';
                } else if (/null/.test(match)) {
                    cls = 'text-magenta';
                }

                return '<span class="' + cls + '">' + match + '</span>';
            }
        );
    }
</script>
</body>
</html>
